@extends('layouts.main', ['title'=> "My courses"])

@section('content')

<div class="my-courses-content">
    <div class="container mx-auto p-4">
        <div class="tab-content-inner">

            <div class="row justify-center">
                @foreach ($courses as $course)
                    <div class="course-item col-md-4">
                        <a href="#">
                            <div class="course-item-inner">
                            <?php $course_picture = json_decode($course->picture); ?>
                            
                                @if (! is_null($course_picture) && $course->picture !="")
                                {{$course->picture}}
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
@endsection