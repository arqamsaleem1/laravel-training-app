@extends('layouts.main', ['title'=> 'Home'])

@section('content')
<div class="container mx-auto px-4">
        <div class="banner-area px-10">
            <div class="home-slider">
                <div class="slide">
                    <div class="slide-image">
                        <img src="{{ asset('images/slide-1.jpg') }}" alt="">
                    </div>
                    <div class="slide-content">
                        <div class="content-container">
                            <h1>Save on New Year’s learning goals</h1>
                            <p>Buy a course from $9.99 by Jan 5 to get our 2023 Trending Skills Guide. Start learning for a <u><a target="_blank" href="#">special bonus offer</a></u>.</p>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="slide-image">
                        <img src="{{ asset('images/slide-1.jpg') }}" alt="">
                    </div>
                    <div class="slide-content">
                        <div class="content-container">
                            <h1>Save on New Year’s learning goals</h1>
                            <p>Buy a course from $9.99 by Jan 5 to get our 2023 Trending Skills Guide. Start learning for a <u><a target="_blank" href="#">special bonus offer</a></u>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cats-slider-area px-10">
            <h2>Learn in-demand professional skills</h2>
            <p>Choose from courses in English and many other languages</p>
            <div class="cat-tabs-area">
                <div class="cat-tabs">
                    <ul>
                        <li class="cat-tab"><a href="#" data-anchor="development-tab" class="active">Development</a></li>
                        <li class="cat-tab"><a href="#" data-anchor="web-development-tab">Web Development</a></li>
                        <li class="cat-tab"><a href="#" data-anchor="business-tab">Business</a></li>
                    </ul>
                </div>
                <div class="cat-tabs-content">
                    <div id="development-tab" class="cat-tab-content active">
                        <div class="tab-content-inner">
                            <div class="tab-content-header">
                                
                            </div>
                            <div class="cat-courses-slider">
                                @foreach ($development_courses as $course)
                                <div class="course-item">
                                    <a href="/course/{{$course->slug}}">
                                        <div class="course-item-inner">
                                        <?php $course_picture = json_decode($course->picture); ?>
                                            @if (! is_null($course_picture) && $course->picture !="")
                                            <div class="course-img">
                                                <img src="{{ asset('storage/') }}{{'/'.$course_picture->dir.'/'.$course_picture->name}}" alt="">
                                            </div>
                                            @else
                                            <div class="course-img placeholder-img">
                                                <img src="{{ asset('images/course-placeholder.webp') }}" alt="">
                                            </div>
                                            @endif
                                            <div class="course-slide-content">
                                                <h4>{{$course->title}}</h4>
                                                <p>{{$course->description}}</p>
                                                <span class="price">${{$course->price}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="web-development-tab" class="cat-tab-content">
                        <div class="tab-content-inner">
                            <div class="cat-courses-slider">
                                @foreach ($web_development_courses as $course)
                                <div class="course-item">
                                    <a href="#">
                                        <div class="course-item-inner">
                                        <?php $course_picture = json_decode($course->picture); ?>
                                            @if (! is_null($course_picture) && $course->picture !="")
                                            
                                            <div class="course-img">
                                                <img src="{{ asset('storage/') }}{{'/'.$course_picture->dir.'/'.$course_picture->name}}" alt="">
                                            </div>
                                            @else
                                            <div class="course-img placeholder-img">
                                                <img src="{{ asset('images/course-placeholder.webp') }}" alt="">
                                            </div>
                                            @endif
                                            <div class="course-slide-content">
                                                <h4>{{$course->title}}</h4>
                                                <p>{{$course->description}}</p>
                                                <span class="price">${{$course->price}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="business-tab" class="cat-tab-content">
                        <div class="tab-content-inner">
                            <div class="cat-courses-slider">
                                @foreach ($business_courses as $course)
                                <div class="course-item">
                                    <a href="#">
                                        <div class="course-item-inner">
                                        <?php $course_picture = json_decode($course->picture); ?>
                                            @if (! is_null($course_picture) && $course->picture !="")
                                            <div class="course-img">
                                                <img src="{{ asset('storage/') }}{{'/'.$course_picture->dir.'/'.$course_picture->name}}" alt="">
                                            </div>
                                            @else
                                            <div class="course-img placeholder-img">
                                                <img src="{{ asset('images/course-placeholder.webp') }}" alt="">
                                            </div>
                                            @endif
                                            <div class="course-slide-content">
                                                <h4>{{$course->title}}</h4>
                                                <p>{{$course->description}}</p>
                                                <span class="price">${{$course->price}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    jQuery(document).ready(function($) {
        $('.home-slider').slick({
            draggable: false,
            prevArrow: '<span class="previous"><i class="fa fa-solid fa-angle-left"></i></span>',
            nextArrow: '<span class="next"><i class="fa fa-solid fa-angle-right"></i></span>'
        });
        $('.cat-courses-slider').slick({
            draggable: false,
            slidesToShow: 5,
            prevArrow: '<span class="previous"><i class="fa fa-solid fa-angle-left"></i></span>',
            nextArrow: '<span class="next"><i class="fa fa-solid fa-angle-right"></i></span>'
        });

        $('li.cat-tab > a').click(function(e) {
            e.preventDefault();
            
            let tabAnchor = $(this).attr('data-anchor');


            $('li.cat-tab > a').removeClass('active');
            $(this).addClass('active');
            
            $('.cat-tabs-content .cat-tab-content').removeClass('active');
            $('.cat-tabs-content #'+tabAnchor).addClass('active');

            setTimeout( function() {
                $('.cat-courses-slider').slick({
                    draggable: false,
                    slidesToShow: 5,
                    prevArrow: '<span class="previous"><i class="fa fa-solid fa-angle-left"></i></span>',
                    nextArrow: '<span class="next"><i class="fa fa-solid fa-angle-right"></i></span>'
                });
            }, 5000);
        });
    });
</script>
@endsection