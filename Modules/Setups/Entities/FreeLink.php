<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class FreeLink extends Model
{
    protected $table = 'freelinks';
    protected $fillable = [
    	'name',
    	'route',
    	'desc',
    	'status',
    ];
}
