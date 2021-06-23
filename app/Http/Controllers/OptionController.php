<?php

namespace App\Http\Controllers;

use App\Http\Resources\OptionResource;
use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Validator;

class OptionController extends Controller
{
    public function index()
    {
        $data = Question::with(['option'])->latest()->get();
        return $data;
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'option'=>'required',
            'question_id'=>'required',
            'is_correct'=>'required'
        ]);
        if ($validator->fails()) {
            return  response(['status' => 'error', 'message' => $validator->errors()->all(), 'data' => []], 400);
        }

        $data= Option::create($request->all());
        return new OptionResource($data);
    }
/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $data = Option::findOrFail($id);
        return new OptionResource($data);
    }
/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'option'=>'required|unique:options,option,'.$id,
            'question_id'=>'required',
            'is_correct'=>'required'
        ]);
        if ($validator->fails()) {
            return  response(['status' => 'error', 'message' => $validator->errors()->all(), 'data' => []], 400);
        }

        Option::find($id)->update($request->all());
        return response()->json(['message'=>'success'],200);
    }

  /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Option::find($id)->delete();
        return response(['status' => 'success', 'message' => "option has been deleted", 'data' => []], 201);
        }
    }