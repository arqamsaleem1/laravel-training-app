<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartAPIController extends Controller
{
    /**
     * Function to handle add to cart button click
     */
    /**
     * @OA\Post(
     *      path="/api/cart",
     *      operationId="storeCart",
     *      tags={"Cart"},
     *      summary="Store new cart",
     *      description="Returns cart data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Cart")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Cart")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function addToCart( Request $request )
    {
        $courseId = $request->course_id;
        $cart = new Cart();

        if (Auth::user()) {
            $useExists = $cart->where('user_id', Auth::user()->id)->where('course_id', $courseId)->get();

            //return count( $useExists ) ;

            if (count($useExists) <= 0) {
                $cart->course_id = $courseId;
                $cart->user_id = Auth::user()->id;
                $cartResponse = $cart->save();

                return response()->json($cartResponse);
            } else {
                return response()->json(false);
            }
        } else {
            return response()->json('not logged in');
        }
    }
    
    /**
     * Function to return total count of the
     * cart items.
     */
    /**
     * @OA\Get(
     *      path="/api/cart/cart-count",
     *      operationId="getCartCount",
     *      tags={"Cart"},
     *      summary="Get cart count",
     *      description="Returns cart count",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Cart")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public static function getCartCount()
    {
        $cart = new Cart;
        
        if (Auth::user()) {
            $cart->user_id = Auth::user()->id;
            $cartCount = $cart->where('user_id', Auth::user()->id)->count();
            
            return response()->json($cartCount);
        } else {
            return response()->json('not logged in');
        }
    }

    /**
     * Function to display cart page
     */
    
    /* public static function showCartPage(  )
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

            return response()->json([
                'cartItems' => $cartItems,
                'cartTotalPrice' => $totalPrice,
            ]);
        } else {
            return response()->json('not logged in');
        }
    } */

    /**
     * Delete the requested item from the cart
     */
    /**
     * @OA\Delete(
     *      path="/api/cart/{id}",
     *      operationId="deleteCartItem",
     *      tags={"Cart"},
     *      summary="Delete cart item for the current user",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Course id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function deleteToCart( $id )
    {
        $courseId = $id;
        $cart = new Cart;

        if ( Auth::user() ) {
            $deletedItem = $cart->where('user_id', Auth::user()->id)->where('course_id', $courseId)->delete();

            return response()->json($deletedItem);
        } else {
            return response()->json('not logged in');
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
    /**
     * @OA\Get(
     *      path="/api/cart",
     *      operationId="getCartItems",
     *      tags={"Cart"},
     *      summary="Get cart items",
     *      description="Returns cart items",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Cart")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
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

        return response()->json($cartItems);
    }

    /**
     * Empty cart for the current user,
     * function to call at the last step of complete order process
     */
    /**
     * @OA\Delete(
     *      path="/api/cart",
     *      operationId="deleteCart",
     *      tags={"Cart"},
     *      summary="Delete cart for the current user",
     *      description="Deletes a record and returns no content",
     *      
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function emptyCart()
    {
        $cart = new Cart;
        $course = new Course;

        //$cartItems = $cart->where('user_id', Auth::user()->id)->get();
        $deletedItem = $cart->where('user_id', Auth::user()->id)->delete();

        return response()->json($deletedItem);
    }
}
