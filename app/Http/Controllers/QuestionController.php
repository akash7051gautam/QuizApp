<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Question;
use Illuminate\Http\Request;
use Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Question::paginate(5);
        return QuestionResource::collection(Question::latest()->get());
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
            'question' => 'required|unique:questions',
            'type' => 'required',
            'point' => 'required',
            'option_id' => 'required',
            'is_correct' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return  response(["status" => "error", 'message' => $validator->errors()->all()], 400);
        }

        $data = Question::create($request->all());
        return new QuestionResource($data);
    }
  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Question::findOrFail($id);
        return new QuestionResource($data);
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
            'question' => 'required|unique:questions,question,' . $id,
            'type' => 'required',
            'point' => 'required',
            'option_id' => 'required',
            'is_correct' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return  response(['status' => 'error', 'message' => $validator->errors()->all(), 'data' => []], 400);
        }

        Question::find($id)->update($request->all());
        return response()->json(['message'=>'success'],200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::find($id)->delete();
        return response(['status' => 'success', 'message' => "Question has been deleted", 'data' => []], 201);
        }
    }
