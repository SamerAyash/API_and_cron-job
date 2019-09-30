<?php

namespace App\Http\Resources;

use App\comment;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{

    public $collects = comment::class;
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
            'comment' => $this->comment,
            //'user'=>$this->user->name
        ];
    }
}
