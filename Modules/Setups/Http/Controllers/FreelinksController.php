<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Freelink;

class FreelinksController extends Controller
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
            'freelinks' => Freelink::all()
        ];
        return view('setups::freelinks.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setups::freelinks.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'route' => 'required|unique:modules'
        ]);

        $role=new Freelink();
        $role->fill($request->all());
        $role->save();

        return is_save($role,'Freelink Has been Added.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('setups::freelinks.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'freelink' => Freelink::findOrFail($id)
        ];
        return view('setups::freelinks.edit',$data);
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
            'route' => 'required',
            'status' => 'required'
        ]);

        $freelink=Freelink::findOrFail($id);
        $freelink->fill($request->all());
        $freelink->save();

        return is_save($freelink,'Freelink has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $freelink=Freelink::find($id)->delete();
        if($freelink){
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
