<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizeResource;
use App\Quize;
use Illuminate\Http\Request;
use Validator;

class QuizeController extends Controller
{
    public function index()
    {
        $data = Quize::paginate(5);
        return QuizeResource::collection($data);
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
            'name' => 'required|unique:quizes,name',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return  response(['status' => 'error', 'message' => $validator->errors()->all(), 'data' => []], 400);
        }
        $data= Quize::create($request->all());
        return new QuizeResource($data);
    }
  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Quize::findOrFail($id);
        return new QuizeResource($data);
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
            'name' => 'required|unique:quizes,name,' . $id,
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return  response(['status' => 'error', 'message' => $validator->errors()->all(), 'data' => []], 400);
        }

        Quize::find($id)->update($request->all());
        return response()->json(['message'=>'success'],200);
    }

    /**
     *Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Quize::find($id)->delete();
        return response(['status' => 'success', 'message' => "Quiz has been deleted", 'data' => []], 201);
        }
    }

