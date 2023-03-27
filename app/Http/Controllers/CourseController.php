<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserWithCourse;
/* use App\Src\Helpers; */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('id', 'DESC')->paginate(10);
        $cats = Category::all();
        $users = User::all();

        //print_r( $courses );
        return view('admin.courses.courses', [
            'courses' => $courses,
            'cats' => $cats,
            'users' => $users,
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myCourses()
    {
        $userWithCourses = UserWithCourse::where('user_id', Auth::user()->id)->get();

        $courses = array();

        foreach ($userWithCourses as $course) {
            $singleCourse = Course::where('id', $course->course_id)->first();
            array_push($courses, $singleCourse);
        }
        //$courses = Course::where()->orderBy('id', 'DESC')->paginate(10);
        /* $cats = Category::all();
        $users = User::all(); */

        /* print_r( $userWithCourses );
        return; */
        return view('admin.courses.myCourses', [
            'courses' => array_filter($courses),
            /* 'cats' => $cats,
            'users' => $users, */
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:courses',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'dropzone-file' => 'mimes:jpeg,bmp,png,gif',
        ]);

        $course = new Course;
        $data = $request->all();
        $course_slug = str_slug($data['title']);
        $is_exists = $course->where('slug', $course_slug)->exists();

        if (! $is_exists) {
            // code...
            $course->title = $data['title'];
            $course->slug = $course_slug;
            $course->description = $data['description'];
            $course->price = $data['price'];
            $course->teacher = ($data['author']) ? $data['author'] : Auth::user()->id;
            $course->category_id = $data['category'];

            // ensure the request has a file before we attempt anything else.
            if ($request->hasFile('dropzone-file')) {
                // Save the file locally in the storage/public/ folder under a new folder named /course-{slug}
                $request->file('dropzone-file')->store('course-'.$course_slug, 'public');
                $picture = [
                    'name' => $request->file('dropzone-file')->hashName(),
                    'dir' => 'course-'.$course_slug,
                ];
                // Store the record, using the new file hashname which will be it's new filename identity.
                $course->picture = json_encode($picture);
            } else {
                $course->picture = '';
            }

            $saveCourse = $course->save();
            session(['success' => 'Course published']);

            return redirect()->to(url()->previous())->withFragment('tabs-addNew-tabVertical');
        } else {
            session(['error' => 'Course slug already exists!']);

            return redirect()->to(url()->previous())->withFragment('tabs-addNew-tabVertical');
        }
    }

    /**
     * Display the specified Course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($course_slug)
    {
        /* if (! Auth::user()) {
            return redirect('/');
        } */

        $course = new Course;

        $current_course = $course->where('slug', '=', $course_slug)->first();

        $teacher = $current_course->teacher()->get();
        $lessons = $current_course->lessons()->get();
        $lessons_sections = $current_course->lessonsSections()->get();
        $current_course->teacher_user = $teacher;
        $current_course->course_sections = $lessons_sections;

        return view('courseDetail', [
            'course' => $current_course,
            'lessons' => $lessons,
        ]);
    }

    /**
     * Display the Course learning page.
     *
     * @param  string  $course_slug
     * @param  int  $lesson_id
     * @return \Illuminate\Http\Response
     */
    public function learnCourse($course_slug, $lesson_id)
    {
        if (! Auth::user()) {
            return redirect('/');
        }

        $course = new Course;
        $lesson = new Lesson;

        $current_course = $course->where('slug', '=', $course_slug)->first();
        $current_lesson = $lesson::find($lesson_id);
        $teacher = $current_course->teacher()->get();
        $lessons = $current_course->lessons()->get();
        $lessons_sections = $current_course->lessonsSections()->get();
        $current_course->teacher_user = $teacher;
        $current_course->course_sections = $lessons_sections;

        return view('coursePlayer', [
            'course' => $current_course,
            'currentLesson' => $current_lesson,
            'allLessons' => $lessons,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($course_slug)
    {
        $course = new Course;
        $cats = Category::all();
        $users = User::all();

        $current_course = $course->where('slug', '=', $course_slug)->first();

        $teacher = $current_course->teacher()->get();
        $category = $current_course->category()->get();
        $current_course->teacher_user = $teacher;
        $current_course->category = $category;

        return view('admin.courses.edit', [
            'course' => $current_course,
            'cats' => $cats,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            'dropzone-file' => 'mimes:jpeg,bmp,png,gif',
        ]);

        $course = new Course;
        $data = $request->all();
        $course_slug = str_slug($data['title']);
        $current_course = Course::find($data['course_id']);

        if ($current_course) {
            // code...
            $current_course->title = $data['title'];
            //$current_course->slug = $course_slug;
            $current_course->description = $data['description'];
            $current_course->price = $data['price'];
            $current_course->teacher = ($data['author']) ? $data['author'] : Auth::user()->id;
            $current_course->category_id = $data['category'];

            // ensure the request has a file before we attempt anything else.
            if ($request->hasFile('dropzone-file')) {
                // Save the file locally in the storage/public/ folder under a new folder named /course-{slug}
                $request->file('dropzone-file')->store('course-'.$course_slug, 'public');
                $picture = [
                    'name' => $request->file('dropzone-file')->hashName(),
                    'dir' => 'course-'.$course_slug,
                ];
                // Store the record, using the new file hashname which will be it's new filename identity.
                $course->picture = json_encode($picture);
            }

            $saveCourse = $current_course->save();
            session(['success' => 'Course updated']);

            return redirect()->to(url()->previous());
        } else {
            session(['error' => 'Course not exists!']);

            return redirect()->to(url()->previous());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id)
    {
        $course = Course::find($course_id);

        if (! is_null($course)) {
            $course->delete();
        }

        return redirect()->to(url()->previous())->withFragment('tabs-allCourses-tabVertical');
    }
}
