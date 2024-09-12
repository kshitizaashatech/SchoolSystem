<?php

namespace App\Models;

use App\Models\FeeCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeGroupType extends Model
{
    use HasFactory;

    protected $table = 'fee_groups_types';

    protected $fillable = ['amount', 'is_active', 'fee_type_id', 'fee_group_id', 'academic_session_id', 'school_id'];


    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }

    public function feeGroup()
    {
        return $this->belongsTo(FeeGroup::class, 'fee_group_id');
    }
    public function feeCollections()
    {
        return $this->hasMany(FeeCollection::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    public function scopeGroupedByFeeGroup($query)
    {
        return $query->groupBy('fee_group_id');
    }
}
