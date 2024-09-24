<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'pdf_image',
        'notice_released_date',
        'notice_who_to_send',
        'municipality_id',
        'created_by'
    ];
    protected $casts = [
        'notice_released_date' => 'date',
        'notice_who_to_send' => 'array',
    ];
}
