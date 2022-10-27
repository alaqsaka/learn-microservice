<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Chapter;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
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
}
