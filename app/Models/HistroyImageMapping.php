<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;


class HistroyImageMapping extends BaseModel
{
    use HasFactory;

    protected $table = 'history_image_mapping';

    protected $fillable = ['history_id', 'image_url'];

}
