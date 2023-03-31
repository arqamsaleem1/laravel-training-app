<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\NewsLetterController;
use App\Jobs\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'renderHomePage'])->name('home');
Route::get('/courses/{category_slug}', [CategoryController::class, 'coursesByCategory']);
Route::get('/test', function(){

    dispatch( new SendMail );
    //return view('test');
});
Route::get('newsletter',[NewsLetterController::class, 'index']);
//Route::get('newsletter-stats',[NewsLetterController::class, 'showStats']);
Route::get('newsletter-stats',[NewsLetterController::class, 'sendEmailToSubscribers']);
Route::post('newsletter/store',[NewsLetterController::class, 'store']);


Route::middleware('auth')->group(function () {
    Route::controller(CourseController::class)->group(function () {
        Route::get('/my-courses', 'myCourses')->name('courses.myCourses');
        Route::get('/course/{course_slug}', 'show');
        Route::get('/course/{course_slug}/learn-course/{lesson_id}', 'learnCourse');
        Route::get('/course/delete/{course_id}', 'destroy')->name('courses.delete');
        Route::post('/course', 'store')->name('courses.store');
        Route::post('/course/update', 'update')->name('courses.update');

        Route::get('/admin/courses', 'index')->middleware(['auth', 'verified'])->name('admin.courses');
        Route::get('/admin/courses/{course_slug}', 'edit')->middleware(['auth', 'verified'])->name('admin.courses.edit');

        Route::get('/admin/lessons', 'index')->middleware(['auth', 'verified'])->name('admin.lessons');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/{category_slug}', 'show');
        Route::get('/category/delete/{category_id}', 'destroy')->name('category.delete');
        Route::post('/category', 'store')->name('category.store');
        Route::post('/category/update', 'update')->name('category.update');

        Route::get('/admin/categories', 'index')->middleware(['auth', 'verified'])->name('admin.categories');
        Route::get('/admin/categories/{category_slug}', 'edit')->middleware(['auth', 'verified'])->name('admin.categories.edit');
    });

    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'showCartPage');
        Route::post('/cart', 'addToCart');
        Route::delete('/cart', 'deleteToCart');
    });

    Route::controller(StripePaymentController::class)->group(function () {
        Route::get('/checkout', 'stripe');
        Route::post('/stripe', 'stripePost')->name('stripe.post');
    });

    Route::get('/user/subscribe', function (Request $request) {
        //Http::withOptions(['verify'=> false]);
        //curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
        //phpinfo();
        $payLink = $request->user()->newSubscription('premium', $premium = 45680)
            ->returnTo(route('home'))
            ->create();

        //print_r($payLink);

        return view('billing', ['paylink' => $payLink]);
    })->name('user.subscribe');

    /* Route::get('/paddle-checkout', function (Request $request) {
        $payLink = Auth::user()->charge(50.0, 'premium');

        return view('checkout-paddle', ['payLink' => $payLink]);
    }); */

    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);

        //return ['token' => $token->plainTextToken];
        //session(['success' => 'Token Generated']);

        //return redirect()->route('dashboard');

        return response()->json(['token' => $token->plainTextToken]);
    })->name('token.create');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
