<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Answer;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\QuestionResource;
use App\Question;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Answer::with(['question'])->latest()->get();
        return $questions;
        // return new AnswerResource($questions);
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
       $data=Validator::make($request->all(),[
        'answer_title'=>'required',
         'question_id'=>'required',
         'is_correct'=>'required'
       ]);

        if($data->fails())
        {
            return response(['status'=>'error','message'=>$data->errors()->all()],400);
        }

        $input=Answer::create($request->all());
        return new AnswerResource($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Answer::find($id);
        return new AnswerResource($data);
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

        Answer::find($id)->update($request->all());
        return response(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Answer::find($id)->delete();
        return response(['status' => 'error', 'message' => "Answer has been deleted", 'data' => []], 201);
    }
}
