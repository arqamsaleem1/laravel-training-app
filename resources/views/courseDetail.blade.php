@extends('layouts.main', ['title'=> ""])

@section('content')
<div class="single-course-page">
    <div class="inner-banner px-10">
        <div class="breadcurm"></div>
        <h1>{{$course->title}} </h1>
        <p>{{$course->description}}</p>
    </div>
    
    <div class="content-div single-course-content">
        <div class="container mx-auto px-4">
            <div class="row">
                <div class="col-md-8">
                    <h2>Course content</h2>
                    @if (Auth::user())
                            
                        @foreach ( $course->course_sections as $tab ) 
                        <div class="course-section-tab">
                            <button class="accordion {{$tab->slug}}-tab">{{$tab->name}}</button>
                            <div class="panel">
                                <ul class="lessons-list">
                                    @foreach ( $lessons as $lesson ) 
                                        @if ($lesson->section_id == $tab->id)
                                        
                                        <li><a href="/course/{{$course->slug}}/learn-course/{{$lesson->id}}"><span><i class="fas fa-play"></i></span> {{$lesson->title}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach

                    @else
                        <p><strong> <em> Purchsae course first to view the content</em></strong></p>
                    @endif
                </div>
                <div class="col-md-4">
                <div class="addtocart-wrap">
                    <div class="addtocart-content">
                        <?php $course_picture = json_decode($course->picture); ?>
                        @if (! is_null($course_picture) && $course->picture !="")
                        <div class="course-picture">
                            <!-- <img src="{{$course->picture}}" alt=""> -->
                            <!-- <img src="https://img-c.udemycdn.com/course/480x270/3082678_ffe8.jpg" alt=""> -->
                            <img src="{{ asset('storage/') }}{{'/'.$course_picture->dir.'/'.$course_picture->name}}" alt="">
                        </div>
                        @endif
                        <div class="cart-content">
                        <div class="course-price">
                            <span class="price">${{$course->price}}</span>
                        </div>
                        <div class="addtocart-btn-area">
                            <a href="#" class="addtocart-btn purchase-btn" data-user='{{Auth::user()->id}}' data-course='{{$course->id}}'>Add to Cart</a>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
            panel.style.display = "none";
            } else {
            panel.style.display = "block";
            }
        });
    }

    $(function(){
        $('.addtocart-btn').click(function(e){
            e.preventDefault();
            let selectedCourse = $(this).data('course');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax(
                {
                    url: "/cart/", 
                    method: "post",
                    data: {'course' : selectedCourse},
                    success: function(result){
                        if ( result ) {
                            location.reload();
                        }
                        else {
                            alert('Item is already in the cart');
                        }
                    }   
                });
            });
    });
</script>
@endsection