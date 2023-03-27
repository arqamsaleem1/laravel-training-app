<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonAPIController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $course_slug )
    {
        $course = new Course;

        $current_course = $course->where('slug', '=', $course_slug)->first();

        $lessons = $current_course->lessons()->get();

        if ($lessons) {
            # code...
            return response()->json($lessons);
        }
        else {
            return response()->json(['error' => 'No lessons for this course!']);
        }

    }
    
    /**
     * Return all course sections.
     *
     * @return \Illuminate\Http\Response
     */
    public function courseSections( $course_slug )
    {
        $course = new Course;

        $current_course = $course->where('slug', '=', $course_slug)->first();
        $lessons_sections = $current_course->lessonsSections()->get();

        if ($lessons_sections) {
            # code...
            return response()->json($lessons_sections);
        }
        else {
            return response()->json(['error' => 'No sections for this course!']);
        }

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
            'title' => 'required',
            'description' => 'required',
            'course_id' => 'required',
            'section_id' => 'required',
        ]);

        
        $lesson = new Lesson;
        $data = $request->all();
        $data['slug'] = str_slug($data['title']);
        $course_slug = Course::find($data['course_id'])->slug;
        $is_exists = Lesson::where('slug', $data['slug'])->exists();
        
        if (! $is_exists) {

            // ensure the request has a file before we attempt anything else.
            if ($request->hasFile('lesson_video')) {
                // Save the file locally in the storage/public/ folder under a new folder named /course-{slug}
                //$request->file('lesson_video')->store('course-'.$data['slug'], 'public');
                //return 'course-'. $course_slug . '/lessons'.'/'.$data['section_id'];
                $request->file('lesson_video')->store('course-'. $course_slug . '/lessons'.'/'.$data['section_id'], 'public');
                $lesson_video = [
                    'name' => $request->file('lesson_video')->hashName(),
                    'dir' => 'course-'. $course_slug . '/lessons'.'/'.$data['section_id'],
                ];
                // Store the record, using the new file hashname which will be it's new filename identity.
                $data["video"] = json_encode($lesson_video);
            }

            $saveLesson = $lesson->create($data);

            return response()->json($saveLesson);
        } else {
            return response()->json(['error' => 'Lesson slug already exists!']);
        }
    }

    public function update(Request $request, Lesson $lesson, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'course_id' => 'required',
            'section_id' => 'required',
        ]);

        $data = $request->all();
        $lesson_slug = str_slug($data['title']);
        $course_slug = Course::find($data['course_id'])->slug;
        $current_lesson = Lesson::find($id);

        $dataToUpdate =array();


        if ($current_lesson) {
            // code...
            $dataToUpdate["title"] = $data['title'];
            $dataToUpdate["slug"] = $lesson_slug;
            $dataToUpdate["description"] = $data['description'];

            // ensure the request has a file before we attempt anything else.
            // ensure the request has a file before we attempt anything else.
            if ($request->hasFile('lesson_video')) {
                // Save the file locally in the storage/public/ folder under a new folder named /lesson-{slug}
                //$request->file('lesson_video')->store('lesson-'.$data['slug'], 'public');
                $request->file('lesson_video')->store('course-'. $course_slug . '/lessons'.'/'.$data['section_id'], 'public');
                $lesson_video = [
                    'name' => $request->file('lesson_video')->hashName(),
                    'dir' => 'course-'. $course_slug . '/lessons'.'/'.$data['section_id'],
                ];
                // Store the record, using the new file hashname which will be it's new filename identity.
                $data["video"] = json_encode($lesson_video);
            }

            //$saveLesson = $current_lesson->save();
            $saveLesson = $current_lesson->update($dataToUpdate);
            return response()->json($saveLesson);
        } else {
            session(['error' => 'Lesson not exists!']);

            return response()->json(['error' => 'Lesson not exists!']);
        }
    }

    public function destroy($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (! is_null($lesson)) {
            $deleted_lesson = $lesson->delete();

            return response()->json($deleted_lesson);
        } else {
            return false;
        }
    }
}
