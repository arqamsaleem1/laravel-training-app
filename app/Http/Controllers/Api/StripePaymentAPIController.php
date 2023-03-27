<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StripePaymentController;
use App\Models\UserWithCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe;

class StripePaymentAPIController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $cartController = new CartController;
        $totalPrice = $cartController->getTotalCartPrice();
        $cartItems = $cartController->getCartItems();

        return response()->json( [
            'cartTotalPrice' => $totalPrice,
            'cartItems' => $cartItems,
        ]);
        /* return view('checkout', [
            'cartTotalPrice' => $totalPrice,
            'cartItems' => $cartItems,
        ]); */
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $cartController = new CartController;
        $StripePaymentController = new StripePaymentController;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $totalPrice = 100 * $cartController->getTotalCartPrice();

        $charge = Stripe\Charge::create([
            'amount' => $totalPrice,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'wallet',
        ]);

        $orderComplete = $StripePaymentController->completeOrder();

        //Session::flash('success', 'Payment successful!');

        if ($orderComplete) {
            return response()->json( ['success' => 'Payment successful!']);
        }
    }

}
