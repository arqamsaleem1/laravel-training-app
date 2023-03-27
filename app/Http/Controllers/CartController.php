<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Function to handle add to cart button click
     */
    public function addToCart(Request $request)
    {
        $courseId = $request->course;
        $cart = new Cart;

        if (Auth::user()) {
            $useExists = $cart->where('user_id', Auth::user()->id)->where('course_id', $courseId)->get();

            //return count( $useExists ) ;

            if (count($useExists) <= 0) {
                $cart->course_id = $courseId;
                $cart->user_id = Auth::user()->id;
                $cartResponse = $cart->save();

                return $cartResponse;
            } else {
                return false;
            }
        } else {
            return 'not logged in';
        }
    }

    /**
     * Function to return total count of the
     * cart items.
     */
    public static function getCartCount()
    {
        $cart = new Cart;

        if (Auth::user()) {
            $cart->user_id = Auth::user()->id;
            $cartCount = $cart->where('user_id', Auth::user()->id)->count();

            return $cartCount;
        } else {
            return 'not logged in';
        }
    }

    /**
     * Function to display cart page
     */
    public static function showCartPage()
    {
        $cart = new Cart;
        $course = new Course;
        $user = new User;

        if (Auth::user()) {
            $cart->user_id = Auth::user()->id;
            $cartItems = $cart->where('user_id', Auth::user()->id)->get();
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $courseItem = $course->find($item->course_id);

                if ($courseItem) {
                    $courseItem->teacherObj = $user->find($courseItem->teacher);
                    $item->courseObj = $courseItem;
                    $totalPrice += $courseItem->price;
                } else {
                    $deleted_item = Cart::where('user_id', Auth::user()->id)->where('course_id', $item->course_id)->delete();
                }
            }

            return view('cartPage', [
                'cartItems' => $cartItems,
                'cartTotalPrice' => $totalPrice,
            ]);
        } else {
            return 'not logged in';
        }
    }

    /**
     * Delete the requested item from the cart
     */
    public function deleteToCart(Request $request)
    {
        $courseId = $request->course;
        $cart = new Cart;

        if (Auth::user()) {
            $deletedItem = $cart->where('user_id', Auth::user()->id)->where('course_id', $courseId)->delete();

            return $deletedItem;
        } else {
            return 'not logged in';
        }
    }

    /**
     * Function that returns Total price of cart items
     */
    public function getTotalCartPrice()
    {
        $cart = new Cart;
        $course = new Course;

        $cartItems = $cart->where('user_id', Auth::user()->id)->get();
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $courseItem = $course->find($item->course_id);

            if ($courseItem) {
                $item->courseObj = $courseItem;
                $totalPrice += $courseItem->price;
            }
        }

        return $totalPrice;
    }

    /**
     * Get all cart items for the current loggenin user
     */
    public function getCartItems()
    {
        $cart = new Cart;
        $course = new Course;
        $user = new User;

        $cart->user_id = Auth::user()->id;
        $cartItems = $cart->where('user_id', Auth::user()->id)->get();
        foreach ($cartItems as $item) {
            $courseItem = $course->find($item->course_id);
            $courseItem->teacherObj = $user->find($courseItem->teacher);

            if ($courseItem) {
                $item->courseObj = $courseItem;
            }
        }

        return $cartItems;
    }

    /**
     * Empty cart for the current user,
     * function to call at the last step of complete order process
     */
    public function emptyCart()
    {
        $cart = new Cart;
        $course = new Course;

        //$cartItems = $cart->where('user_id', Auth::user()->id)->get();
        $deletedItem = $cart->where('user_id', Auth::user()->id)->delete();

        return $deletedItem;
    }
}
