<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class IPAddress extends BaseModel
{
    use HasFactory;

    protected $table = 'ip_address';
    
    protected $fillable = ['ip_address','created_at'];
}
