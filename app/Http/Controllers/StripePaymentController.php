<?php

namespace App\Http\Controllers;

use App\Models\UserWithCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $cartController = new CartController;
        $totalPrice = $cartController->getTotalCartPrice();
        $cartItems = $cartController->getCartItems();

        return view('checkout', [
            'cartTotalPrice' => $totalPrice,
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $cartController = new CartController;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $totalPrice = 100 * $cartController->getTotalCartPrice();

        $charge = Stripe\Charge::create([
            'amount' => $totalPrice,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'wallet',
        ]);

        $orderComplete = $this->completeOrder();

        //Session::flash('success', 'Payment successful!');
        session(['success' => 'Payment successful!']);
        if ($orderComplete) {
            return back();
        }
    }

    /**
     * Complete order process after the purchase,
     * Last step in the purchase process
     */
    public function completeOrder()
    {
        $cartController = new CartController;
        $userWithCourse = new UserWithCourse;

        $cartItems = $cartController->getCartItems();

        foreach ($cartItems as $item) {
            $userWithCourse->course_id = $item->course_id;
            $userWithCourse->user_id = Auth::user()->id;
        }

        $userWithCourseResponse = $userWithCourse->save();

        if ($userWithCourseResponse) {
            // code...
            $cartItems = $cartController->emptyCart();

            return true;
        } else {
            return false;
        }
    }
}
