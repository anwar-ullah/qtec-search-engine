<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
    	'name',
    	'route',
    	'icon',
    	'desc',
        'serial',
    	'status'
    ];

    function menu(){
    	return $this->hasMany(Menu::class);
    }
}
