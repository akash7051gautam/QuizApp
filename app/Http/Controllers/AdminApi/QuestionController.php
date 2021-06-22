<?php
namespace App\Http\Controllers\AdminApi;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\QuestionResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\QuestionEditResource;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with(['answer'])->paginate(10);
        return QuestionResource::collection($questions);
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
            'title'=>'required',
            'type'=>'required',
            'points'=>'required',
            'page'=>'required'
        ]);
        if($data->fails()){
            return response(['status'=>'error','message'=>$data->errors()->all()],400);
        }
            $data = $request->merge(['user_id'=>auth()->user()->id,'quiz_id'=>(int)$request->quiz_id])->except(['options']);            
           // dd($data);
            $question = Question::create($data);
            $question_id = $question->id;
            $options = $request->options;
            $is_correct = $request->is_correct;

            $answer = [];
            foreach($options as $key=>$option){
                $answer = [
                        'answer_title' => $option,
                        'question_id' => $question_id,
                        'is_correct' => $is_correct[$key]
                ];   
                $question = Answer::create($answer);             
            }
            return new QuestionResource($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $questions = Question::where(['quiz_id'=>$id])->paginate(10);
        return QuestionResource::collection($questions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = Question::where('id',$id);
        $question = $query->with(['answer'])->latest()->first();
        return response()->json($question,200);
        //return new QuestionResource($question);
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
            'title'=>'required',
            'type'=>'required',
            'points'=>'required',
            'page'=>'required'
        ]);
        if($data->fails()){
            return response(['status'=>'error','message'=>$data->errors()->all()],400);
        }
            $data = $request->merge(['user_id'=>auth()->user()->id,'quiz_id'=>(int)$request->quiz_id])->except(['options']); 
            //dd($data);
            $question = Question::find($id);
            $question->update($data);

            $question_id = $question->id;
            $options = $request->options;
            $is_correct = $request->is_correct;
            $ansId = $request->ansId;

            $answer = [];
            foreach($options as $key=>$option){
                $answer = [
                        'answer_title' => $option,
                        'question_id' => $question_id,
                        'is_correct' => $is_correct[$key]
                ];   
                $answer = Answer::where('id',$ansId[$key])->update($answer);      
            }
            //return new QuestionResource($question);
            return response()->json(['message'=>'success'],201);
        // $data=Validator::make($request->all(),[
        //     'title'=>'unique:Questions,title,'.$id,
        // ]);
        // if ($data->fails()) {
        //     return response(['status' => 'error', 'message' => $data->errors()->all(), 'data' => []], 400);
        // }
        // Question::find($id)->update($request->all());
        // return response()->json(['message'=>'success'],200);
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
