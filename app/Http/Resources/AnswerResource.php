<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return[
            'id'=>$this->id,
            'answer_title'=>$this->answer_title,
           'question_id'=>$this->question_id,
           'created_at'=>$this->created_at->diffForHumans(),
           'updated_at'=>$this->updated_at->diffForHumans(),
        ];
    }
}
