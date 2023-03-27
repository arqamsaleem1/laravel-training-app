@extends('layouts.main', ['title'=> ""])

@section('content')
<div class="cart-page">
    <div class="inner-banner px-10">
        <div class="breadcurm"></div>
        <h1> </h1>
        <p></p>
    </div>
    
    <div class="content-div cart-content">
        <div class="container-new mx-auto px-4">
            <div class="row">
                <div class="col-md-9">
                    <h2>Cart</h2>
                    @if (Auth::user())
                       <?php if( count($cartItems) > 0 ): ?>
                            @foreach ($cartItems as $item)
                            <div class="course-item">
                                <?php $course_picture = json_decode($item->courseObj->picture); ?>
                                @if (! is_null($course_picture) && $item->courseObj->picture !="")
                                <div class="course-img">
                                    <img src="{{ asset('storage/') }}{{'/'.$course_picture->dir.'/'.$course_picture->name}}" alt="">
                                </div>
                                @endif
                                <div class="course-item-content">
                                    <h3>{{$item->courseObj->title}}</h3>
                                    <p>{{$item->courseObj->description}}</p>

                                    <p class="pt-4"><strong>By:</strong> <span class="teacher">{{$item->courseObj->teacherObj->name}}</span></p>
                                </div>
                                <div class="cart-tab-actions">
                                    <a href="#" class="remove-cart-btn" data-user='{{Auth::user()->id}}' data-course='{{$item->courseObj->id}}'>Remove</a>
                                </div>
                                <div class="course-item-price">
                                    <span class="price">${{$item->courseObj->price}}</span>
                                </div>
                            </div>
                            @endforeach
                        <?php else: ?>
                            <p><strong> <em> Cart is empty! </em></strong></p>
                        <?php endif; ?>
                    @else
                        <p><strong> <em> Cart is empty! </em></strong></p>
                    @endif
                </div>
                <div class="col-md-3">
                <div class="cart-sidebar-wrap">
                    <div class="cart-sidebar-content">
                        <p><strong>Total:</strong></p>
                        <h3 class="total-price">${{$cartTotalPrice}}</h3>

                        <p><a href="/checkout" class="checkout-btn purchase-btn">Checkout</a></p>
                    </div>
                </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.remove-cart-btn').click(function(e){
            e.preventDefault();
            let selectedCourse = $(this).data('course');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax(
                {
                    url: "/cart", 
                    type: 'DELETE',
                    data: {'course' : selectedCourse},
                    success: function(result){
                        console.log(result);
                        if ( result ) {
                            location.reload();
                        }
                    }   
                });
            });
    });
</script>

@endsection