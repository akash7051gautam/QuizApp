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
        // return parent::toArray($request);

        return[
           'id'=>$this->id,
           'title'=>$this->title,
           'user_id'=>$this->user_id,
           'type'=>$this->type,
           'points'=>$this->points,
           'created_at'=>$this->created_at->diffForHumans(),
           'updated_at'=>$this->updated_at->diffForHumans(),
        ];
    }
}
