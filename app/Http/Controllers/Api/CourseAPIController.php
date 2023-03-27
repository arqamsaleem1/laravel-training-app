<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
/* use App\Src\Helpers; */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/courses",
     *      operationId="getCoursesList",
     *      tags={"Courses"},
     *      summary="Get list of courses",
     *      description="Returns list of courses",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        $courses = Course::paginate(10);
        /* $cats = Category::all();
        $users = User::all(); */

        return response()->json($courses);
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
    /**
     * @OA\Post(
     *      path="/api/courses",
     *      operationId="storeCourse",
     *      tags={"Courses"},
     *      summary="Store new course",
     *      description="Returns course data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Course")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:courses',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            //'dropzone-file' => 'mimes:jpeg,bmp,png,gif',
        ]);

        $course = new Course;
        $data = $request->all();
        $course_slug = str_slug($data['title']);
        $is_exists = Course::where('slug', $course_slug)->exists();
        $dataToSave =array();
        //return $course_slug;
        if (! $is_exists) {
            // code...
            $dataToSave["title"] = $data['title'];
            $dataToSave["slug"] = $course_slug;
            $dataToSave["description"] = $data['description'];
            $dataToSave["price"] = $data['price'];
            $dataToSave["teacher"] = ($data['author']) ? $data['author'] : Auth::user()->id;
            $dataToSave["category_id"] = $data['category'];

            // ensure the request has a file before we attempt anything else.
            if ($request->hasFile('picture')) {
                // Save the file locally in the storage/public/ folder under a new folder named /course-{slug}
                $request->file('picture')->store('course-'.$course_slug, 'public');
                $picture = [
                    'name' => $request->file('picture')->hashName(),
                    'dir' => 'course-'.$course_slug,
                ];
                // Store the record, using the new file hashname which will be it's new filename identity.
                //$course->picture = json_encode($picture);
                $dataToSave["picture"] = json_encode($picture);
            } else {
                $dataToSave["picture"] = '';
            }
            //return $dataToSave;
            $saveCourse = $course->create($dataToSave);

            return response()->json($saveCourse);
        } else {
            return response()->json(['error' => 'Course slug already exists!']);
        }
    }

    /**
     * Display the specified Course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/courses/{id}",
     *      operationId="getCourseById",
     *      tags={"Courses"},
     *      summary="Get course information",
     *      description="Returns course data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Course id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id)
    {
        /* if (! Auth::user()) {
            return redirect('/');
        } */

        $course = new Course;

        $current_course = $course->find($id);
        return $current_course;
        $teacher = $current_course->teacher()->get();
        $lessons = $current_course->lessons()->get();
        $lessons_sections = $current_course->lessonsSections()->get();
        $current_course->teacher_user = $teacher;
        $current_course->course_sections = $lessons_sections;

        return response()->json($current_course);
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
    /* public function edit($course_slug)
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
    } */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/api/courses/{id}",
     *      operationId="updateCourse",
     *      tags={"Courses"},
     *      summary="Update existing course",
     *      description="Returns updated course data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Course id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Course")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(Request $request, Course $course, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category' => 'required',
            /* 'dropzone-file' => 'mimes:jpeg,bmp,png,gif', */
        ]);

        //$course = new Course;
        $data = $request->all();
        $course_slug = str_slug($data['title']);
        $current_course = Course::find($id);
        //$current_course = $course;
        $dataToUpdate =array();


        if ($current_course) {
            // code...
            $dataToUpdate["title"] = $data['title'];
            $dataToUpdate["slug"] = $course_slug;
            $dataToUpdate["description"] = $data['description'];
            $dataToUpdate["price"] = $data['price'];
            $dataToUpdate["teacher"] = ($data['author']) ? $data['author'] : Auth::user()->id;
            $dataToUpdate["category_id"] = $data['category'];

            // ensure the request has a file before we attempt anything else.
            if ($request->hasFile('picture')) {
                // Save the file locally in the storage/public/ folder under a new folder named /course-{slug}
                $request->file('picture')->store('course-'.$course_slug, 'public');
                $picture = [
                    'name' => $request->file('picture')->hashName(),
                    'dir' => 'course-'.$course_slug,
                ];
                // Store the record, using the new file hashname which will be it's new filename identity.
                $dataToUpdate["picture"] = json_encode($picture);
            }

            //$saveCourse = $current_course->save();
            $saveCourse = $current_course->update($dataToUpdate);
            return response()->json($saveCourse);
        } else {
            session(['error' => 'Course not exists!']);

            return response()->json(['error' => 'Course not exists!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *      path="/api/courses/{id}",
     *      operationId="deleteCourse",
     *      tags={"Courses"},
     *      summary="Delete existing course",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Course id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($course_id)
    {
        $course = Course::find($course_id);

        if (! is_null($course)) {
            $deleted_course = $course->delete();

            return response()->json($deleted_course);
        } else {
            return false;
        }
    }
}
