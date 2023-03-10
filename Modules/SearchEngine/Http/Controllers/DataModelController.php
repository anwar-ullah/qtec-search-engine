<?php

namespace Modules\SearchEngine\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DB, DataTables;
use \Modules\SearchEngine\Entities\DataModel;

class DataModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(
                    DataModel::when(!datatableOrdering(), function($query){
                        return $query->orderBy('id', 'desc');
                    })
                )
                ->addIndexColumn()
                ->addColumn('actions', function($model){
                    return view('layouts.crudButtons', [
                        'text' => 'Data Model',
                        'object' => $model,
                        'link' => 'search-engine/data-models'
                    ])->render();
                })
                ->rawColumns(['actions', 'content'])
                ->make(true);
        }

        return view('searchengine::dataModels.index', [
            'headerColumns' => [
                ['SL', 'SL', 'text-center'],
                ['title', 'title', 'text-center'],
                ['fine_points', 'fine_points', 'text-center'],
                ['actions', 'actions', 'text-center']
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('searchengine::dataModels.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'fine_points' => 'required',
            'content' => 'required',
        ]);

        $model = DataModel::create($request->all());
        return response()->json([
            'success' => true,
            'message' => "Data Model Has been Added."
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('searchengine::dataModels.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('searchengine::dataModels.edit', [
            'model' => DataModel::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'fine_points' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);

        $model = DataModel::findOrFail($id);
        $model->fill($request->all())->save();
        return response()->json([
            'success' => true,
            'message' => "Data Model Has been updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(DataModel::find($id)->delete()){
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong!'
        ]);
    }
}
