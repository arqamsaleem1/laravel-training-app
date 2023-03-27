@extends('layouts.main', ['title'=> ''])

@section('content')
<link href="https://vjs.zencdn.net/8.0.4/video-js.css" rel="stylesheet" />
<div class="courses-player px-10">
    <div class="container">
        <div class="inner-container">
            <section class="main-video">
                <?php $lesson_video = json_decode($currentLesson->video); ?>
                
                <video src="{{ Vite::asset('public/storage') . '/' . $lesson_video->dir . '/' . $lesson_video->name }}" controls autoplay muted>
                </video>
                <h1 class="title">{{$currentLesson->title}}</h1>
            </section>

            <section class="video-playlist">
                <h3 class="title">{{$course->title}}</h3>
                <p>{{ count($allLessons) }} lessons &nbsp; . &nbsp; 50m 48s</p>
                <div class="videos">
                @foreach ( $course->course_sections as $tab ) 
                <div class="course-section-tab <?php if ( $currentLesson->section_id == $tab->id ) echo 'first-active-tab' ?>">
                    <button class="accordion {{$tab->slug}}-tab <?php if ( $currentLesson->section_id == $tab->id ) echo 'active' ?>">Section {{$loop->index+1}}: {{$tab->name}}</button>
                    <div class="panel" <?php if ( $currentLesson->section_id == $tab->id ) echo 'style="display:block;"' ?>>
                        <ul class="lessons-list">
                            @foreach ( $allLessons as $lesson ) 
                                @if ($lesson->section_id == $tab->id)
                                
                                <li class="<?php if ( $currentLesson->id == $lesson->id ) echo 'current-item' ?>"><a href="/course/{{$course->slug}}/learn-course/{{$lesson->id}}"><span><i class="fas fa-play"></i></span>{{$lesson->title}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
                </div>
            </section>
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
</script>
@endsection