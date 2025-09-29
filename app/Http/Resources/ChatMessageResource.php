<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chat_id' => $this->chat_id,
            'from' => $this->from,
            'to' => $this->to,
            'chat_id' => $this->chat_id,
            'message_text' => $this->message_text,
            'time'=>$this->time,
            'word_count'=>$this->word_count,
            'image_count'=>$this->image_count,
            'images'=>json_decode($this->images),
            'created_at'=>$this->created_at,
            
        ];
    }
}
