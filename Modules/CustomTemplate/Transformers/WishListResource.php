<?php

namespace Modules\CustomTemplate\Transformers;
use  Modules\CustomTemplate\Transformers\CustomTemplateResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return [

            'id' => $this->id,
            'user_id'=>$this->user_id,   
            'template_data'=>new CustomTemplateResource($this->template_data),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

           

    ];
    }
}
