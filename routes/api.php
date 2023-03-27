<?php

use App\Http\Controllers\Api\CartAPIController;
use App\Http\Controllers\Api\CategoryAPIController;
use App\Http\Controllers\Api\CourseAPIController;
use App\Http\Controllers\Api\LessonAPIController;
use App\Http\Controllers\Api\StripePaymentAPIController;
use App\Http\Controllers\Api\UserAPIController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/* Route::get('/course/{course_slug}', [CourseController::class, 'show']);

Route::get('/', [HomeController::class, 'renderHomePage'])->name('home');
Route::get('/courses/{category_slug}', [CategoryController::class, 'coursesByCategory']); */

Route::middleware('auth:sanctum')->group(function () {
    
    Route::controller(CourseAPIController::class)->group(function () {
        Route::get('/courses', 'index')->name('courses')->can('viewAny', '\App\Models\Course');
        Route::get('/courses/{id}', 'show')->can('view', '\App\Models\Course');
        Route::get('/courses/{course_slug}/learn-course/{lesson_id}', 'learnCourse');
        Route::delete('/courses/{id}', 'destroy')->name('courses.delete')->can('delete', '\App\Models\Course');
        Route::post('/courses', 'store')->name('courses.store')->can('create', '\App\Models\Course');
        Route::put('/courses/{id}', 'update')->name('courses.update')->can('update', '\App\Models\Course');

        /* Route::get('/admin/courses/{course_slug}', 'edit')->middleware(['auth', 'verified'])->name('courses.edit');

        Route::get('/admin/lessons', 'index')->middleware(['auth', 'verified'])->name('lessons'); */
    });

    Route::controller(CategoryAPIController::class)->group(function () {
        Route::get('/categories', 'index')->name('categories')->can('viewAny', '\App\Models\Category');
        Route::get('/categories/{category_id}', 'show')->can('view', '\App\Models\Category');
        Route::post('/categories', 'store')->name('categories.store')->can('create', '\App\Models\Category');
        Route::put('/categories/{id}', 'update')->name('categories.update')->can('update', '\App\Models\Category');
        Route::delete('/categories/{category_id}', 'destroy')->name('categories.delete')->can('delete', '\App\Models\Category');

        /* Route::get('/admin/categories', 'index')->middleware(['auth', 'verified'])->name('admin.categories');
        Route::get('/admin/categories/{category_slug}', 'edit')->middleware(['auth', 'verified'])->name('admin.categories.edit'); */
    });
    
    Route::controller(UserAPIController::class)->group(function () {
        Route::get('/users', 'index')->name('users')->can('viewAny', '\App\Models\User');
        Route::get('/users/{user_id}', 'show')->can('view', '\App\Models\User');
        Route::post('/users', 'store')->name('users.store')->can('create', '\App\Models\User');
        Route::post('/login', 'login')->name('users.login')->can('viewAny', '\App\Models\User');
        Route::put('/users/{id}', 'update')->name('users.update')->can('update', '\App\Models\User');
        Route::delete('/users/{user_id}', 'destroy')->name('users.delete')->can('delete', '\App\Models\User');
    });

    Route::controller(CartAPIController::class)->group(function () {
        Route::get('/cart/cart-count', 'getCartCount')->can('viewAny', '\App\Models\Cart');
        Route::get('/cart', 'getCartItems')->can('viewAny', '\App\Models\Cart');
        Route::post('/cart', 'addToCart')->can('create', '\App\Models\Cart');
        Route::delete('/cart/{id}', 'deleteToCart')->can('delete', '\App\Models\Cart');
        Route::delete('/cart', 'emptyCart')->can('delete', '\App\Models\Cart');
    });
    
    Route::controller(LessonAPIController::class)->group(function () {
        Route::get('/lessons/{course_id}', 'index')->can('view', '\App\Models\Course');
        Route::delete('/lessons/{id}', 'destroy')->name('lessons.delete')->can('delete', '\App\Models\Course');
        Route::post('/lessons', 'store')->name('lessons.store')->can('create', '\App\Models\Course');
        Route::put('/lessons/{id}', 'update')->name('lessons.update')->can('update', '\App\Models\Course');
    });

    Route::controller(StripePaymentAPIController::class)->group(function () {
        Route::get('/checkout', 'checkout');
        Route::post('/checkout', 'stripePost')->name('stripe.post');
    });
});
/* Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['auth:api']
  ], function () {
      Route::apiResource('courses', 'CourseController');
}); */
