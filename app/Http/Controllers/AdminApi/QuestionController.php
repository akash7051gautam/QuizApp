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
            'page'=>'required',
            'quiz_id'=>'required'
        ]);
        if($data->fails()){
            return response(['status'=>'error','message'=>$data->errors()->all()],400);
        }
            $data = $request->merge(['user_id'=>auth()->user()->id,'quiz_id'=>(int)$request->quiz_id])->except(['answer']);
            //$data = $request->merge(['user_id'=>1,'quiz_id'=>(int)$request->quiz_id])->except(['answer']);

            $question = Question::create($data);
            
            $question_id = $question->id;
            if($request->type !== 'Paragraph'){
                $answers = $request->only('answer');
            
                foreach( $answers['answer'] as $answer ){
                    $question->answer()->create($answer);
                }
            }
            $resp = $question->with('answer')->where('id',$question_id)->first();
            //return response()->json(['status'=>'success','message'=>'Question has been Inserted'],201);
            return response()->json($resp,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $question = Question::select()
            ->when($request->get('param') == "quiz_id", function ($query) use ($id) {
                $query->where(['quiz_id'=>$id])->paginate(10);
            })
            ->when($request->get('param') == "question_id", function ($query) use ($id) {
                $query->where(['id'=>$id])->with(['answer'])->latest();
            });
        if( $request->get('param') == "quiz_id" ){
            return QuestionResource::collection($question->get());
        }else if($request->get('param') == "question_id"){
            return response()->json($question->first(),200);
        }
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
        //dd($request->all());
        $data=Validator::make($request->all(),[
            'title'=>'required',
            'type'=>'required',
            'points'=>'required',
            'page'=>'required'
        ]);
        if($data->fails()){
            return response(['status'=>'error','message'=>$data->errors()->all()],400);
        }

        $question = $request->merge([
                'user_id'=>auth()->user()->id,
                'quiz_id'=>(int)$request->quiz_id
            ])->except(['answer']);
      //  $question['type'] = $request->type['name'];
        $update = Question::find($id)->update($question);

        $answers = $request->only('answer');
        foreach( $answers['answer'] as $answer  ){
            Answer::where('id',$answer['id'])->update($answer);
        }
        return response()->json(['status'=>'success','message'=>'Question has been updated'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::find($id)->answer()->delete();
        Question::find($id)->delete();
        return response(['status' => 'error', 'message' => "Question has been deleted", 'data' => []], 201);
    }
}
