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
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'question' => $this->question,
            'type' => $this->type,
            'point' => $this->point,
            'created_at'=>$this->created_at->diffForHumans(),
            'updated_at'=>$this->updated_at->diffForHumans()
        ];
    }
}
