<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    public function showCheckout(Request $request)
    {
        $checkout = $request->user()->newSubscription('default', 'price_1RQF1dDdEJpfTh4AsTnFR0k5') // ここにStripeの価格ID
            ->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => url('/'),
            ]);

        return redirect($checkout->url);
    }
}
