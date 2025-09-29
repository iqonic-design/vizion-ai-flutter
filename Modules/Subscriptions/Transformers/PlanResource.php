<?php

namespace Modules\Subscriptions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'duration' => $this->duration,
            'amount' => $this->amount,
            'playstore_identifier' => $this->playstore_identifier,
            'appstore_identifier' => $this->appstore_identifier,
            'identifier' => $this->identifier,
            'trial_period' => $this->trial_period,
            'planlimitation' => $this->planlimitation,
            'description' => $this->description,
            'status' => $this->status, 
            'limits' =>PlanlimitationMappingResource::collection($this->planLimitation),
            
        ];
    }
}
