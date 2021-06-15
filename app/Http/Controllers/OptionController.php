<?php

namespace App\Http\Controllers;

use App\Http\Resources\OptionResource;
use App\Option;
use Illuminate\Http\Request;
use Validator;

class OptionController extends Controller
{
    public function index()
    {
        $data = Option::paginate(10);
        return OptionResource::collection($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id'=>'required|unique:options,question_id',
            'is_correct'=>'required'
        ]);
        if ($validator->fails()) {
            return  response(["status" => "error", "data" => []], 400);
        }

        $data = new Option();
        $data->question_id = $request->question_id;
        $data->is_correct = $request->is_correct;
        if ($data->save()) {
            return new OptionResource($data);
        }
    }

    public function show($id)
    {
        $data = Option::findOrFail($id);
        return new OptionResource($data);
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question_id'=>'required',
            'is_correct'=>'required'
        ]);
        if ($validator->fails()) {
            return  response(["data" => [], "status" => "error"], 400);
        }

        $data = Option::FindOrFail($id);
        $data->question_id = $request->question_id;
        $data->is_correct = $request->is_correct;
        if ($data->save()) {
            return new OptionResource($data);
        }
    }

  
    public function destroy($id)
    {
        $data = Option::findOrFail($id);
        if ($data->delete()) {
            return new OptionResource($data);
        }
    }
}
