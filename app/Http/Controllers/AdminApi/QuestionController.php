<?php
namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Validator;



class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return auth()->user()->get();
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
       $data=Validator::make($request->all(),[
        'title'=>'required|unique:Questions',
        'user_id'=>'required',
        'type'=>'required',
        'points'=>'required',
        'page'=>'required'
        ]);
        if($data->fails())
        {
            return response(['status'=>'error','message'=>$data->errors()->all()],400);
        }
        // dd($request->all());
         $input=Question::create($request->all());
        return new QuestionResource($input);
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Question::findOrFail($id);
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
        $data=Validator::make($request->all(),[
            'title'=>'unique:Questions,title,'.$id,
        ]);
        if ($data->fails()) {
            return response(['status' => 'error', 'message' => $data->errors()->all(), 'data' => []], 400);
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
        return response(['status' => 'error', 'message' => "Question has been deleted", 'data' => []], 201);
    }
}
