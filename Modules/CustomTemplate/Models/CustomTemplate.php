<?php

namespace Modules\CustomTemplate\Models;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Models\Category;
use Modules\Subscriptions\Models\Plan;

class CustomTemplate extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customtemplates';

    protected $fillable = ['template_name', 'description', 'category_id', 'package_id','status', 'inculde_voice_tone', 'userinput_list','option_data','custom_prompt'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\CustomTemplate\database\factories\CustomTemplateFactory::new();
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $user = auth()->user();
            if ($user && User::where('id', $user->id)->whereIn('user_type', ['admin', 'demo_admin'])->exists()) {
                $model->created_by = null;
                $model->updated_by = null;
            }
        });

        static::saving(function ($table) {
            //
        });

        static::updating(function ($table) {
            //
        });
    }

    protected function getFeatureImageAttribute()
    {
        $media = $this->getFirstMediaUrl('feature_image');

        return isset($media) && ! empty($media) ? $media : default_feature_image();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function package()
    {
        return $this->belongsTo(Plan::class, 'package_id');
    }

}
