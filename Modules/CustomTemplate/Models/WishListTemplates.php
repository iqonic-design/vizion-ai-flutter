<?php

namespace Modules\CustomTemplate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WishListTemplates extends Model
{
    use HasFactory;

    protected $table = 'wishlist_templates';

    protected $fillable = ['user_id', 'template_id'];

    protected static function newFactory()
    {
        return \Modules\CustomTemplate\Database\factories\WishListTemplatesFactory::new();
    }

    public function template_data()
    {
        return $this->belongsTo(CustomTemplate::class, 'template_id');
    }


}
