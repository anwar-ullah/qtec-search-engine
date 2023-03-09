<?php

namespace Modules\Lead\Entities;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'goods_id',
        'publisher_id',
        'leads_id',
        'status',
    ];

    function histories(){
        return $this->hasMany(LeadHistory::class);
    }
}
