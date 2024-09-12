<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcaActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'pdf_image', 'player_type', 'is_active', 'eca_head_id'
    ];

    public function schools()
    {
        return $this->belongsToMany(School::class, 'eca_activity_school');
    }

    public function ecaHead()
    {
        return $this->belongsTo(ExtraCurricularHead::class, 'eca_head_id');
    }
}
