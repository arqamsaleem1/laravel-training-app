@extends('layouts.main', ['title'=> "Checkout"])

@section('content')
<div class="checkout-page">
    <div class="content-div checkout-content">
        <div class="container-new mx-auto px-4">
            <div class="row">
                <div class="col-md-9">
                    <h2>Checkout</h2>
                    @if (Auth::user())
                    @if (Session::has('success'))
                        <div class="w-full max-w-lg mb-5 alert alert-success alert alert-success bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md">
                            <p>{{ Session::get('success') }}</p>
                            {{Session::forget('success');}}
                        </div>
                    @endif
    
                    <form 
                            role="form" 
                            action="{{ route('stripe.post') }}" 
                            method="post" 
                            class="require-validation w-full max-w-lg"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                        @csrf
    
                        <div class='form-row flex flex-wrap -mx-3 mb-6'>
                            <div class='w-full px-3 required'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Name on Card</label> 
                                <input
                                    class='appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500' size='4' type='text'>
                            </div>
                        </div>
    
                        <div class='form-row flex flex-wrap -mx-3 mb-6'>
                            <div class='w-full px-3 card required'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Card Number</label> 
                                <input
                                    autocomplete='off' class='appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 card-number' size='20'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='flex flex-wrap -mx-3 mb-6'>
                            <div class='w-full md:w-1/3 px-3 mb-6 md:mb-0'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>CVC</label> 
                                <input autocomplete='off'
                                    class='appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='w-full md:w-1/3 px-3 mb-6 md:mb-0'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Expiration Month</label> 
                                <input
                                    class='appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-whitel card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='w-full md:w-1/3 px-3 mb-6 md:mb-0'>
                                <label class='block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2'>Expiration Year</label> <input
                                    class='appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-whitel card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row flex flex-wrap -mx-3 mt-6'>
                            <div class=' error w-full px-3 mb-6 md:mb-0 hidden'>
                                <div class='alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
    
                        <div class="form-row flex flex-wrap -mx-3 mt-6">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <button class="checkout-btn purchase-btn" type="submit">Pay Now (${{$cartTotalPrice}})</button>
                            </div>
                        </div>
                            
                    </form>
                    @endif
                </div>
                <div class="col-md-3">
                <div class="checkout-sidebar-wrap sidebar">
                    <div class="checkout-sidebar-content">
                        <h3><strong>Summary:</strong></h3>
                        <ul class="cart-items">
                            @foreach ($cartItems as $item)
                                <li class="flex flex-wrap mb-2">
                                    <span class="item-name w-full md:w-3/4 px-1 md:mb-0">{{$item->courseObj->title}}</span>
                                    <span class="item-price w-full md:w-1/4 px-1 md:mb-0 text-right">${{$item->courseObj->price}}</span>
                                </li>

                            @endforeach

                            <li class="total-price flex flex-wrap ml-1 mt-6 pt-2 border-t-2 border-solid border-black">
                                <span class="item-name w-full md:w-3/4 px-1 md:mb-0 font-bold">Total</span>
                                <span class="item-price w-full md:w-1/4 px-1 md:mb-0 font-bold text-right">${{$cartTotalPrice}}</span>
                            </li>
                        </ul>

                        <!-- <p><a href="#" class="checkout-btn purchase-btn">Checkout</a></p> -->
                    </div>
                </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
  
$(function() {
  
    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/
    
    var $form = $(".require-validation");
     
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
    
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
     
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
    
    });
      
    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hidden')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
                 
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
</script>
@endsection