<?php

namespace Modules\SearchEngine\Entities;

use Illuminate\Database\Eloquent\Model;

class SearchDataModel extends Model
{
    protected $fillable = [
        'search_id',
        'data_model_id',
        'content',
    ];

    function search(){
        return $this->belongsTo(Search::class);
    }

    function dataModel(){
        return $this->belongsTo(DataModel::class);
    }
}
