<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizes = quiz::paginate(10);
        return QuizResource::collection($quizes);
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
        $request->validate([
            'name' => 'required|unique:quizzes,name',
            'status' => 'required'
        ]);
        $quizes = new quiz();
        $quizes->name= $request->name;
        $quizes->status= $request->status;
        if ($quizes->save())
        {
            return new QuizResource($quizes);
        }
        else{
            return response(["status"=>"error","message" => "Data Already Exist"], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quizes = quiz::findOrFail($id);
        return new QuizResource($quizes);
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
        $quizes = quiz::FindOrFail($id);
        $quizes->name = $request->name;
        $quizes->status = $request->status;
        if($quizes->save())
        {
            return new QuizResource($quizes);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quizes = quiz::findOrFail($id);
        if($quizes->delete())
        {
            return new QuizResource($quizes);
        }
    }
}
