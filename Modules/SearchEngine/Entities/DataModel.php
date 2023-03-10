<?php

namespace Modules\SearchEngine\Entities;

use Illuminate\Database\Eloquent\Model;

class DataModel extends Model
{
    protected $fillable = [
        'title',
        'fine_points',
        'content',
        'status',
    ];

    function searches(){
        return $this->hasMany(SearchDataModel::class);
    }
}
