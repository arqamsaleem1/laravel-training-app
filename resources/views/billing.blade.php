@extends('layouts.main', ['title'=> "Checkout"])
@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Billing') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <x-paddle-button :url="$paylink" class="px-8 py-4">
                        Buy
                    </x-paddle-button>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="content-div checkout-content">
        <div class="container-new mx-auto px-4">
            <div class="row">
                <div class="col-md-9">
                    <h2>Checkout</h2>
                    @if (Auth::user())
                    <x-paddle-button :url="$paylink" class="px-8 py-4">
                        Buy
                    </x-paddle-button>
                    @endif
                </div>
                <div class="col-md-3">
                <div class="checkout-sidebar-wrap sidebar">
                    <div class="checkout-sidebar-content">

                        <!-- <p><a href="#" class="checkout-btn purchase-btn">Checkout</a></p> -->
                    </div>
                </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection