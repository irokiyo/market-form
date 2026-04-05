<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Trade;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Illuminate\Support\Facades\Auth;

class StripeCheckoutController extends Controller
{
    public function create(Request $request, Item $item)
    {
        $request->validate(
            ['payment_method' => 'required'],
            ['payment_method.required' => '支払い方法を選択してください']
        );

        $paymentMethod = PaymentMethod::findOrFail($request->payment_method);

        if ($paymentMethod->payment_method === 'コンビニ払い') {
            if ($item->order()->exists()) {
                return redirect()
                ->route('show', $item->id)
                ->with('error', 'この商品はすでに売り切れています');
            }

            Order::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
            ]);

            $trade = Trade::create([
                    'buyer_id'=>Auth::id(),
                    'seller_id'=>$item->user_id,
                    'item_id'=>$item->id,
                    'status'=>Trade::STATUS_IN_PROGRESS,
                    'buyer_completed_at'=> null,
                    'seller_reviewed_at'=> null,
                ]);


            return redirect()->route('chat.show', ['trade' => $trade->id]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
        'mode' => 'payment',
        'payment_method_types' => ['card'],
        'line_items' => [[
            'quantity' => 1,
            'price_data' => [
                'currency' => 'jpy',
                'unit_amount' => (int) $item->price,
                'product_data' => [
                    'name' => $item->name,
                ],
            ],
        ]],
        'metadata' => [
            'item_id' => (string) $item->id,
            'user_id' => (string) Auth::id(),
            'payment_method_id' => (string) $paymentMethod->id,
            'postcode' => (string) $request->postcode,
            'address' => (string) $request->address,
            'building' => (string) ($request->building ?? ''),
        ],
        'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'  => route('checkout.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        $itemId = $session->metadata->item_id ?? null;
        $buyerId = $session->metadata->user_id ?? null;

        if (!$itemId || !$buyerId) {
            return redirect()->route('index');
        }

        $trade = Trade::where('item_id', $itemId)
            ->where('buyer_id', $buyerId)
            ->latest()
            ->first();

        if (!$trade) {
            return redirect()->route('index');
    }

    return redirect()->route('chat.show', ['trade' => $trade->id]);
    }

    public function cancel()
    {
        return redirect()->route('index');
    }
}
