<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Functions;

class FunctionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [
            'functions' => Functions::all()
        ];
        return view('setups::functions.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setups::functions.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:functions',
        ]);

        $function=new Functions();
        $function->fill($request->all());
        $function->save();

        return is_save($function,'Function Has been Added.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('setups::functions.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'function' => Functions::findOrFail($id)
        ];
        return view('setups::functions.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $function=Functions::findOrFail($id);
        $function->fill($request->all());
        $function->save();

        return is_save($function,'Function has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $function=Functions::find($id)->delete();
        if($function){
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
