<?php

namespace Modules\CustomTemplate\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class CustomTemplateResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    { 
        $user_id = $request->has('user_id') && $request->user_id !== null ? $request->user_id : auth()->id();

        return [

                'id' => $this->id,
                'template_name' => $this->template_name,
                'description' => $this->description,
                'category_id' => $this->category_id,
                'category_slug'=>optional($this->category)->slug,
                'package_id' => $this->package_id,
                'identifier' => optional($this->package)->identifier,
                'status' => $this->status,
                'template_image' => $this->media->pluck('original_url')->first(),
                'inculde_voice_tone' => $this->inculde_voice_tone,
                'userinput_list' => json_decode($this->userinput_list,true),
                'is_wishlist'=> checkTemplateInWishList($this->id, $user_id),
                'custom_prompt' => $this->custom_prompt, 
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at,

        ];
    }
}
