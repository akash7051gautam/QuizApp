<?php

namespace App\Http\Controllers\AdminApi;

use App\UserAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserAnswerResource;


class UserAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Auth::user()->id;
        return UserAnswerResource::collection(UserAnswer::latest()->get());
        ;
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
          'question_id'=>'required',
          'answer_type'=>'required',
          'single_choice'=>'required',
          'multiple_choice'=>'required'
        ]);
        if($data->fails())
        {
            return response(['status'=>'error','message'=>$data->errors()->all()],400);
        }
    // return Auth::user();
     $input=UserAnswer::create($request->all());
     return new UserAnswerResource($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=UserAnswer::find($id);
        return new UserAnswerResource($data);
        // return $id;
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
        // return Auth::user();
        UserAnswer::find($id)->update($request->all());
        return response(['status'=>'Updated Successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserAnswer::find($id)->delete();
        return response(['status' => 'error', 'message' => "User Answer has been deleted", 'data' => []], 201);
    }
}
