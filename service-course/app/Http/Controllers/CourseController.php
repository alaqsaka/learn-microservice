<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::query();

        $q = $request->query('q');
        $status = $request->query('status');

        $courses->when($q, function ($query) use ($q) {
            return $query->whereRaw("name LIKE '%" . strtolower($q) . "%'");
        });

        $courses->when($status, function ($query) use ($status) {
            return $query->where('status', '=', $status);
        });

        return response()->json([
            'status' => 'success',
            'data' => $courses->paginate(10)
        ], 200);
    }

    // detail course
    public function show($id)
    {
        $course =  Course::find($id);

        // check if id exist in database
        if (!$course) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course not found'
            ]);
        }

        // mendapatkan review course
        $reviews = Review::where('course_id', '=', $id)->get()->toArray();

        // mendapatkan jumlah student yang mengambil course
        $totalStudent = MyCourse::where('course_id', '=', $id)->count();

        $course['reviews'] = $reviews;
        $course['total_student'] = $totalStudent;

        return response()->json([
            'status' => 'success',
            'data' => $course
        ]);
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published',
            'price' => 'integer',
            'level' => 'required|in:all-level,beginner,intermediate,advance',
            'mentor_id' => 'required|integer',
            'description' => 'string'
        ];

        // mengambil semua data dari req.body
        $data = $request->all();

        // validate
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // mengecek apakah mentor_id ada di database
        $mentorId = $request->input('mentor_id');

        $mentor = Mentor::find($mentorId);
        // if mentor with this id is not found
        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor with this id is not found'
            ], 404);
        }

        // insert data to database
        $course = Course::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $course
        ], 200);
    }

    // update course
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'certificate' => 'boolean',
            'thumbnail' => 'string|url',
            'type' => 'in:free,premium',
            'status' => 'in:draft,published',
            'price' => 'integer',
            'level' => 'in:all-level,beginner,intermediate,advance',
            'mentor_id' => 'integer',
            'description' => 'string'
        ];

        // mengambil semua data dari req.body
        $data = $request->all();

        // validate
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // check if id course available in database
        $course = Course::find($id);
        // if course id is not found
        if (!$course) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course not found'
            ], 404);
        }

        // check if mentor_id is exist in database
        $mentorId = $request->input('mentor_id');
        if ($mentorId) {
            // mengecek mentor id atau engga
            $mentor = Mentor::find($mentorId);
            // if mentor with this id is not found
            if (!$mentor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mentor with this id is not found'
                ], 404);
            }
        }

        // updata data course
        $course->fill($data);
        $course->save();

        return response()->json([
            'status' => 'success',
            'data' => $course
        ], 200);
    }

    // delete course
    public function destroy($id)
    {
        $course = Course::find($id);

        // if course with this id is not found
        if (!$course) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course not found'
            ], 404);
        }

        // delete course
        $course->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Course successfully deleted'
        ]);
    }
}
