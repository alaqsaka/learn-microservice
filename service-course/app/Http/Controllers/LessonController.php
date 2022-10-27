<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Chapter;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    // get list of lessons
    public function index(Request $request)
    {
        $lessons = Lesson::query();

        $chapterId = $request->query('chapter_id');

        $lessons->when($chapterId, function ($query) use ($chapterId) {
            return $query->where('chapter_id', '=', $chapterId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $lessons->get()
        ]);
    }

    // detail lesson
    public function show($id)
    {
        $lesson = Lesson::find($id);
        // check if lesson exist in database
        if (!$lesson) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lesson not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }

    // Create lesson
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'video' => 'required|string',
            'chapter_id' => 'required|integer'
        ];

        // get data from req.body
        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // check if chapter_id exist
        $chapterId = $request->input('chapter_id');
        $chapter = Chapter::find($chapterId);

        // if chapter not found
        if (!$chapter) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chapter not found'
            ]);
        }

        // save lesson data to database
        $lesson = Lesson::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'video' => 'string',
            'chapter_id' => 'integer'
        ];

        // get data from req.body
        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // check if lesson exist in database
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lesson not found'
            ], 404);
        }

        // check if chapter_id exist in database
        $chapterId = $request->input('chapter_id');
        if ($chapterId) {
            $chapter = Chapter::find($chapterId);
            if (!$chapter) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Chapter not found'
                ]);
            }
        }

        $lesson->fill($data);
        $lesson->save();

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }

    public function destroy($id)
    {
        // check if lesson id exist in database
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lesson not found'
            ], 404);
        }

        $lesson->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson successfully deleted'
        ]);
    }
}
