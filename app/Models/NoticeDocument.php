<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'notice_id',
        'type',
        'name',
        'date',
        'path' 
    ];

}
