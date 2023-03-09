<?php

namespace Modules\Setups\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
    	'name',
    	'is_main',
    	'sub_roles',
    	'permissions',
    	'desc',
    	'status'
    ];

    function users(){
        return $this->hasMany(\App\User::class,'role_id','id');
    }
}
