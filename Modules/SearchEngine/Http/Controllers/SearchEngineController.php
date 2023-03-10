<?php

namespace Modules\SearchEngine\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use \Modules\SearchEngine\Entities\DataModel;
use \Modules\SearchEngine\Entities\Search;
use \Modules\SearchEngine\Entities\SearchDataModel;

class SearchEngineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }

    public function index()
    {
        $models = [];
        if(request()->has('search') && !empty(request()->get('search'))){
            $models = DataModel::where(function($query){
                return $query->where('title', 'LIKE', '%'.request()->get('search').'%')
                             ->orWhere('fine_points', 'LIKE', '%'.request()->get('search').'%')
                             ->orWhere('content', 'LIKE', '%'.request()->get('search').'%');
            })
            ->where('status', 1)
            ->paginate(5);


            if(isset($models[0])){
                $search = Search::create([
                    'user_id' => auth()->user()->id,
                    'keyword' => request()->get('search'),
                ]);
                $searches = [];
                foreach ($models as $key => $model) {
                    array_push($searches, [
                        'search_id' => $search->id,
                        'data_model_id' => $model->id,
                        'content' => view('searchengine::content', [
                            'search' => request()->get('search'),
                            'model' => $model
                        ])->render(),
                    ]);
                }

                if(isset($searches[0])){
                    SearchDataModel::insert($searches);
                }
            }
        }

        return view('searchengine::index', [
            'models' => $models
        ]);
    }

    public function show($id)
    {
        return view('searchengine::content', [
            'search' => request()->get('search'),
            'model' => DataModel::findOrFail($id)
        ]);
    }
}
