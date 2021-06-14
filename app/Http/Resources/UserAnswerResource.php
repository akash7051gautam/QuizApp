<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAnswerResource extends JsonResource
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
        return [
            'user_id'=>$this->user_id,
            'question_id'=>$this->question_id,
            'answer_type'=>$this->answer_type,
            'single_choice'=>$this->single_choice,
            'multiple_choice'=>$this->multiple_choice
        ];
    }
}
