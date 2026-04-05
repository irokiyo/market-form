<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\Trade;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
        Log::info('stripe webhook reached');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        $secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            return new Response('Invalid payload/signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            Log::info('checkout.session.completed received', [
                'session_id' => $session->id ?? null,
                'metadata' => $session->metadata ? $session->metadata->toArray() : [],
            ]);

            $itemId = $session->metadata->item_id ?? null;
            $buyerId = $session->metadata->user_id ?? null;
            $paymentMethodId = $session->metadata->payment_method_id ?? null;
            $postcode = $session->metadata->postcode ?? null;
            $address = $session->metadata->address ?? null;
            $building = $session->metadata->building ?? null;

            if (!$itemId || !$buyerId || !$paymentMethodId || !$postcode || !$address) {
                Log::error('Missing metadata', [
                'item_id' => $itemId,
                'user_id' => $buyerId,
                'payment_method_id' => $paymentMethodId,
                'postcode' => $postcode,
                'address' => $address,
                'building' => $building,
                ]);
            return new Response('Missing metadata', 400);
            }

            try {
                DB::transaction(function () use (
                $itemId,
                $buyerId,
                $paymentMethodId,
                $postcode,
                $address,
                $building
            )
            {
                $item = Item::lockForUpdate()->findOrFail($itemId);

                Log::info('item found', ['item_id' => $item->id]);

                if (Order::where('item_id', $item->id)->exists()) {
                    Log::info('order already exists', ['item_id' => $item->id]);
                    return;
                }

                Order::create([
                    'user_id' => $buyerId,
                    'item_id' => $itemId,
                    'payment_method_id' => $paymentMethodId,
                    'postcode' => $postcode,
                    'address' => $address,
                    'building' => $building ?: null,
                ]);

                Log::info('order created', ['item_id' => $itemId, 'buyer_id' => $buyerId]);

                Trade::create([
                    'buyer_id' => $buyerId,
                    'seller_id' => $item->user_id,
                    'item_id' => $itemId,
                    'status' => Trade::STATUS_IN_PROGRESS,
                    'buyer_completed_at' => null,
                    'seller_reviewed_at' => null,
                ]);

                Log::info('trade created', ['item_id' => $itemId, 'buyer_id' => $buyerId]);
            });
            } catch (\Throwable $e) {
                Log::error('Stripe webhook failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                ]);

                return new Response('Webhook error', 500);
            }
        }

        return new Response('ok', 200);
    }
}
