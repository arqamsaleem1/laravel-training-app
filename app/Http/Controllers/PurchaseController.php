<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function pay()
    {
        $paylink = Auth::user()->charge(50.0, 'Premium');

        return view('billing', [
            'paylink' => $paylink,
        ]);
    }
}
