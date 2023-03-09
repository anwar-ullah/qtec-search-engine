<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $table='menu';

    protected $fillable = [
    	'name',
    	'module_id',
    	'route',
    	'icon',
    	'desc',
        'serial',
    	'status'
    ];

    function module(){
    	return $this->belongsTo(Module::class);
    }

    function submenu(){
    	return $this->hasMany(Submenu::class);
    }

    function options(){
    	return $this->hasMany(Option::class)->where('submenu_id',0);
    }
}
