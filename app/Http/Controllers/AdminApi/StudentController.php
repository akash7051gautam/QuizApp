<?php

namespace App\Http\Controllers\AdminApi;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StudentResource::collection(Student::all());
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
        $input = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'roll_no' => 'required',
            'email' => 'required|unique:students',
            'status' => 'required',
            'password' => 'required'
        ]);
        if ($input->fails()) {
            return response(['status' => 'error', 'message' => $input->errors()->all()], 400);
        }

        $data = Student::create();
        $data->first_name=$request->first_name;
        $data->last_name=$request->last_name;
        $data->roll_no=$request->roll_no;
        $data->email=$request->email;
        $data->status=$request->status;
        $data->user_id=$request->user_id;
        $data->password=bcrypt($request->password);
        return new StudentResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $get = Student::find($id);
        return new StudentResource($get);
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
        $input = Validator::make($request->all(), [

            'email' => 'required|unique:students,email,' . $id

        ]);
        if ($input->fails()) {
            return response(['status' => 'error', 'message' => $input->errors()->all()], 400);
        }

        Student::find($id)->update($request->all());
        return response()->json(['message' => 'success'], 201);
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
        return response(['status' => 'success', 'message' => 'Student has been Deleted', 'data' => []], 201);
    }
}
