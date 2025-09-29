<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class ChatHistoryImage extends BaseModel
{
    use HasFactory;

    protected $table = 'chat_history_image';

    protected $fillable = ['id','user_id'];
}
