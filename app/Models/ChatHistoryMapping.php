<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class ChatHistoryMapping extends BaseModel
{
    use HasFactory;

    protected $table = 'chat_history_mapping';

    protected $fillable = ['chat_id','from','to','message_text','time','word_count','image_count','images'];

}
