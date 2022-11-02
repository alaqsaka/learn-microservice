<?php

namespace App\Http\Controllers;

use App\Models\ImageCourse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageCourseController extends Controller
{
    // create image course
    public function create(Request $request)
    {
        $rules = [
            'image' => 'required|url',
            'course_id' => 'required|integer',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }


        // check if course_id exist in database
        $courseId = $request->input('course_id');
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course not found'
            ], 404);
        }

        $imageCourse = ImageCourse::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $imageCourse
        ]);
    }

    // delete image course
    public function destroy($id)
    {
        $imageCourse = ImageCourse::find($id);
        // check if id exist in database
        if (!$imageCourse) {
            return response()->json([
                'status' => 'error',
                'message' => 'Image Course not found'
            ], 404);
        }

        $imageCourse->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Image Course successfully deleted',
        ]);
    }
}
