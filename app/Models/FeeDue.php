<?php

namespace App\Models;

use App\Models\Classg;
use App\Models\Section;
use App\Models\FeeGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeDue extends Model
{
    use HasFactory;
    protected $fillable = [
        'fee_groups_id',
        'class_id',
        'section_id',
        'is_active'
    ];

    public function feeGroups()
    {
        return $this->belongsTo(FeeGroup::class, 'fee_groups_id');
    }
    public function classes()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
