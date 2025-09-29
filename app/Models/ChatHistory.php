<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class ChatHistory extends BaseModel
{
    use HasFactory;


    protected $table = 'chat_history';

    protected $fillable = ['id','user_id','title'];
}
