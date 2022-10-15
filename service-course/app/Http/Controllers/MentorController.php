<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{
    // POST REQUEST CREATE MENTOR
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        // Jika ada error
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // Insert data mentor to database
        $mentor = Mentor::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    // PUT REQUEST UPDATE MENTOR
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        // Jika ada error
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // check if mentor_id exist in database
        $mentor = Mentor::find($id);

        // if mentor_id exist
        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor with this id not found'
            ], 404);
        }

        // if exist
        $mentor->fill($data);
        $mentor->save();

        // success response
        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    // get mentor list
    public function index()
    {
        $mentors = Mentor::all();
        return response()->json([
            "status" => 'success',
            "data" => $mentors
        ]);
    }

    // get mentor detail
    public function show($id)
    {
        $mentor = Mentor::find($id);

        // if mentor with $id is not found
        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor with this id is not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ], 200);
    }

    // delete mentor
    public function destroy($id)
    {
        $mentor = Mentor::find($id);

        // if mentor with $id is not found
        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mentor with this id is not found'
            ], 404);
        }

        //if mentor found

        $mentor->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Mentor successfully deleted'
        ]);
    }
}
