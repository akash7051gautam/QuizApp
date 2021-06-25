<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'roll_no'=>$this->roll_no,
            'email'=>$this->email,
            'password'=>$this->status,
            'status'=>$this->status,
            'created_at'=>$this->created_at->diffForHumans(),
        ];
    }
}
