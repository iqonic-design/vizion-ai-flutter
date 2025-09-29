<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Modules\CustomTemplate\Models\CustomTemplate;
use Modules\Service\Models\SystemService;

class History extends BaseModel
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = ['user_id', 'type', 'history_data','word_count','image_count','template_id'];


    public function historyimage()
    {
        return $this->hasMany(HistroyImageMapping::class, 'history_id', 'id');
    }

    public function templatedata()
    {
        return $this->belongsTo(CustomTemplate::class, 'template_id');
    }

    public function SystemService()
    {
        return $this->belongsTo(SystemService::class, 'type','type');
    }




}
