<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'location',
        'user_id'
    ];

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }

}
