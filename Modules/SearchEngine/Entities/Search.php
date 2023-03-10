<?php

namespace Modules\SearchEngine\Entities;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'user_id',
        'keyword',
    ];

    function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    function dataModels(){
        return $this->hasMany(SearchDataModel::class);
    }
}
