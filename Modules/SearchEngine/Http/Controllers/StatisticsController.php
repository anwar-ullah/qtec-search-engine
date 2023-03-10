<?php

namespace Modules\SearchEngine\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use \App\Models\User;
use \Modules\SearchEngine\Entities\DataModel;
use \Modules\SearchEngine\Entities\Search;
use \Modules\SearchEngine\Entities\SearchDataModel;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }

    public function index()
    {
        $keywords = [];
        $searches =  Search::groupBy('keyword')->get();
        if(isset($searches[0])){
            foreach($searches as $key => $keyword){
                $keywords[$keyword->keyword] = Search::where('keyword', $keyword->keyword)->count();
            }
        }

        return view('searchengine::statistics.index', [
            'keywords' => $keywords,
            'users' => User::has('searches')->get(),
        ]);
    }

    public function store(Request $request){
        $from = isset(explode(' - ', $request->daterange)[0]) && strtotime(strtotime(explode(' - ', $request->daterange)[0])) > 0 ? date('Y-m-d', strtotime(explode(' - ', $request->daterange)[0])) : '';
        $to = isset(explode(' - ', $request->daterange)[1]) && strtotime(strtotime(explode(' - ', $request->daterange)[1])) > 0  ? date('Y-m-d', strtotime(explode(' - ', $request->daterange)[1])) : '';
        $keywords = $request->keywords;
        $users = $request->users;

        $searchDataModels = SearchDataModel::with([
            'dataModel',
            'search.user'
        ])
        ->when(!empty($from), function($query) use($from){
            return $query->whereHas('search', function($query) use($from){
                return $query->where(DB::raw('substr(`created_at`, 1, 10)'), '>=', $from);
            });
        })
        ->when(!empty($to), function($query) use($to){
            return $query->whereHas('search', function($query) use($to){
                return $query->where(DB::raw('substr(`created_at`, 1, 10)'), '<=', $to);
            });
        })
        ->when(isset($keywords[0]), function($query) use($keywords){
            return $query->whereHas('search', function($query) use($keywords){
                return $query->whereIn('keyword', $keywords);
            });
        })
        ->when(isset($users[0]), function($query) use($users){
            return $query->whereHas('search', function($query) use($users){
                return $query->whereIn('user_id', $users);
            });
        })->paginate(5);

        return view('searchengine::statistics.search-data-models', [
            'searchDataModels' => $searchDataModels
        ]);
    }
}
