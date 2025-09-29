<?php

namespace Modules\Subscriptions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request){


      $data= [

        'id' => $this->id,
        'name' => $this->name, 
        'plan_id' => $this->plan_id,
        'user_id' => $this->user_id, 
        'start_date' => $this->start_date, 
        'end_date' => $this->end_date, 
        'status' => $this->status, 
        'amount' => $this->amount, 
        'identifier' => $this->identifier, 
        'type' => $this->type, 
        'duration' => $this->duration, 
        'plan_type' => $this->plan_type,
        'payment_id' => $this->payment_id, 
        'user_name'=>optional($this->user)->full_name,

      ];

      return $data;

      }
}
