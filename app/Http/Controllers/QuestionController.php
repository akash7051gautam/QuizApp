<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Question;
use Illuminate\Http\Request;
use Validator;

class QuestionController extends Controller
{
    public function index()
    {
        $data = Question::paginate(10);
        return QuestionResource::collection($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|unique:questions,question',
            'type'=>'required',
            'point'=>'required',
            'option_id'=>'required',
            'is_correct'=>'required',
            'user_id'=>'required'
        ]);
        if ($validator->fails()) {
            return  response(["status" => "error", "data" => []], 400);
        }

        $data = new Question();
        $data->question = $request->question;
        $data->type = $request->type;
        $data->point = $request->point;
        $data->option_id = $request->option_id;
        $data->is_correct = $request->is_correct;
        $data->user_id = $request->user_id;
        if ($data->save()) {
            return new QuestionResource($data);
        }
    }

    public function show($id)
    {
        $data = Question::findOrFail($id);
        return new QuestionResource($data);
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|unique:questions,question,'. $id,
            'type'=>'required',
            'point'=>'required',
            'option_id'=>'required',
            'is_correct'=>'required',
            'user_id'=>'required'
        ]);
        if ($validator->fails()) {
            return  response(["data" => [], "status" => "error"], 400);
        }

        $data = Question::FindOrFail($id);
        $data->question = $request->question;
        $data->type = $request->type;
        $data->point = $request->point;
        $data->option_id = $request->option_id;
        $data->is_correct = $request->is_correct;
        $data->user_id = $request->user_id;
        if ($data->save()) {
            return new QuestionResource($data);
        }
    }

  
    public function destroy($id)
    {
        $data = Question::findOrFail($id);
        if ($data->delete()) {
            return new QuestionResource($data);
        }
    }
}
