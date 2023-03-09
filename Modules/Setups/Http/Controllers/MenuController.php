<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Menu;

class MenuController extends Controller
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
        return $this->show(0);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('name','asc')->get(),
        ];
        return view('setups::menu.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial' => 'required',
            'name' => 'required',
            'module_id' => 'required',
            'route' => 'required',
        ]);

        $role=new Menu();
        $role->fill($request->all());
        $role->save();

        return is_save($role,'Menu Has been Added.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($module_id)
    {
        
        $data = [
            'module_id' => $module_id,
            'modules' => Module::where('status',1)->orderBy('name','asc')->get(),
            'menu' => Menu::when($module_id>0,function($query) use($module_id){
                                return $query->where('module_id',$module_id);
                            })
                            ->orderBy('serial','asc')
                            ->get(),
        ];
        return view('setups::menu.index',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('name','asc')->get(),
            'menu' => Menu::findOrFail($id)
        ];
        return view('setups::menu.edit',$data);
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
            'serial' => 'required',
            'name' => 'required',
            'module_id' => 'required',
            'status' => 'required'
        ]);

        $role=Menu::findOrFail($id);
        $role->fill($request->all());
        $role->save();

        return is_save($role,'Menu has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $role=Menu::find($id)->delete();
        if($role){
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
