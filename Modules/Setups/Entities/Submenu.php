<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
	protected $table='submenu';

    protected $fillable = [
    	'name',
    	'menu_id',
    	'route',
    	'icon',
    	'desc',
        'serial',
    	'status'
    ];

    function menu(){
    	return $this->belongsTo(Menu::class);
    }

    function options(){
    	return $this->hasMany(Option::class);
    }
}
