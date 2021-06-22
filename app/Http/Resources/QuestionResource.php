<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
           'page' => $this->page,
           'quiz_id'=> $this->quiz_id,
           'question'=>$this->title,
           'options' => $this->answer,
           'type' => $this->type,
           'created_at' => $this->created_at
        ];
    }
}
