<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\quiz;
use Illuminate\Http\Request;
use Validator;

class QuizController extends Controller
{
    public function index()
    {
        $quizes = quiz::paginate(10);
        return QuizResource::collection($quizes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:quizzes,name',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return  response(["data" => [], "status" => "error"], 400);
        }
        $quizes = new quiz();
        $quizes->name = $request->name;
        $quizes->status = $request->status;
        if ($quizes->save()) {
            return new QuizResource($quizes);
        }
    }

    public function show($id)
    {
        $quizes = quiz::findOrFail($id);
        return new QuizResource($quizes);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:quizzes,name,' . $id,
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return  response(["data" => [], "status" => "error"], 400);
        }

        $quizes = quiz::FindOrFail($id);
        $quizes->name = $request->name;
        $quizes->status = $request->status;
        if ($quizes->save()) {
            return new QuizResource($quizes);
        }
    }
    public function destroy($id)
    {
        $quizes = quiz::findOrFail($id);
        if ($quizes->delete()) {
            return new QuizResource($quizes);
        }
    }
}
