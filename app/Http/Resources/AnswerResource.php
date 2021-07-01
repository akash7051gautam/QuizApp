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
        //return parent::toArray($request);
        return[
                'id' => $this->id,
                'question' => $this->question->title,
                'options' => [
                    'option' => $this->answer_title, 
                    'is_correct' => $this->is_correct
                ]
            ];
    }
}
