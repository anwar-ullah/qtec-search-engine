<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;

class LeadHistory extends Model
{
    protected $fillable = [
        'lead_id',
        'status',
        'comment',
        'user_id',
    ];

    function lead(){
        return $this->belongsTo(Lead::class);
    }

    function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
}
