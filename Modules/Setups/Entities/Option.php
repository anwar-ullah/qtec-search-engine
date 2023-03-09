<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
    	'name',
    	'menu_id',
    	'submenu_id',
    	'desc',
    	'status'
    ];

    function menu(){
    	return $this->belongsTo(Menu::class);
    }

    function submenu(){
    	return $this->belongsTo(Submenu::class);
    }
}
