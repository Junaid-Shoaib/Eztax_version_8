<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'tax_authority',
        'tax_office',
        'notice_heading',
        'commissioner',
        'tax_year',
        'status',
        'receiving_date',
        'due_date',
        'hearing_date',
        'notice_name',
        'notice_path',
        'reply_name',
        'reply_path',
        'order_name',
        'order_path',
        'user_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
