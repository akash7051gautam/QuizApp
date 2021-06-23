<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Student::latest()->paginate(10);
        return StudentResource::collection($data);
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
            'roll_no'=>'required',
             'email'=>'required',
             'first_name'=>'required',
             'last_name'=>'required',
             'password'=>'required',
             'user_id'=>'required',
             'status'=>'required',

           ]);
    
            if($data->fails())
            {
                return response(['status'=>'error','message'=>$data->errors()->all()],400);
            }
    
            $input=Student::create($request->all());
            return new StudentResource($input);
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Student::find($id);
        return new StudentResource($data);
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

        $data=Validator::make($request->all(),[
            'roll_no'=>'required',
             'email'=>'required|unique:students,email,'.$id,
             'first_name'=>'required',
             'last_name'=>'required',
             'password'=>'required',
             'user_id'=>'required',
             'status'=>'required',

           ]);
    
            if($data->fails())
            {
                return response(['status'=>'error','message'=>$data->errors()->all()],400);
            }
        $data=Student::find($id)->update($request->all());
        return response(['status'=>'success','message'=>'Updated Successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->delete();
        return response(['status' => 'success', 'message' => "Student has been deleted", 'data' => []], 201);
    }
}
