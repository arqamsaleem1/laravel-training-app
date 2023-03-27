@extends('layouts.main', ['title'=> ''])

@section('content')
<div class="courses-page px-10">
    <div class="container mx-auto px-4">
        <h2>{{$current_cat->name}} Courses</h2>
        <?php if (count($category_courses) > 0): ?>
        <div class="row">
            <div class="col-4 filters-sidebar">
                <h3>Filters</h3>
            </div>
            <div class="col-8">
                <div class="courses-div">
                @foreach ($category_courses as $course)
                    <a href="/course/{{$course->slug}}">
                        <div class="course-item">
                        <?php $course_picture = json_decode($course->picture); ?>
                        @if (! is_null($course_picture) && $course->picture !="")
                            <div class="course-img">
                                <img src="{{ asset('storage/') }}{{'/'.$course_picture->dir.'/'.$course_picture->name}}" alt="">
                            </div>
                        @endif
                            <div class="course-item-content">
                                <h3>{{$course->title}}</h3>
                                <p>{{$course->description}}</p>
                            </div>
                            <div class="course-item-price">
                                <span class="price">${{$course->price}}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
                </div>
            </div>
        </div>
        <?php else: ?>
            <p style="text-align: center; padding: 30px;" class="px-10"> <strong>No courses in this category</strong> </p>
        <?php endif; ?>
    </div>
</div>
@endsection