<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
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

    $itemId = $session->metadata->item_id ?? null;
    $buyerId = $session->metadata->user_id ?? null;
    $paymentMethodId = $session->metadata->payment_method_id ?? null;
    $postcode = $session->metadata->postcode ?? null;
    $address = $session->metadata->address ?? null;
    $building = $session->metadata->building ?? null;

    if (!$itemId || !$buyerId || !$paymentMethodId || !$postcode || !$address) {
        Log::error('Missing metadata', (array) $session->metadata);
        return new Response('Missing metadata', 400);
    }

    DB::transaction(function () use (
        $itemId,
        $buyerId,
        $paymentMethodId,
        $postcode,
        $address,
        $building
    ) {
        $item = Item::lockForUpdate()->findOrFail($itemId);

        if (Order::where('item_id', $item->id)->exists()) {
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
    });
}


        return new Response('ok', 200);
    }
}
