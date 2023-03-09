<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Module;

class ModulesController extends Controller
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
            'modules' => Module::orderBy('serial','asc')->get()
        ];


        // $modules = Module::whereNotIn('id', [6,17])->get();
        // foreach ($modules as $key => $module) {
        //     if(isset($module->menu[0])){
        //         foreach ($module->menu as $key => $this_menu) {
        //             if(isset($this_menu->submenu[0])){
        //                 foreach ($this_menu->submenu as $key => $this_submenu) {
        //                     if(isset($this_submenu->options[0])){
        //                         foreach ($this_submenu->options as $key => $option) {
        //                             $option->delete();
        //                         }
        //                     }

        //                     $this_submenu->delete();
        //                 }
        //             }

        //             if(isset($this_menu->options[0])){
        //                 foreach ($this_menu->options as $key => $option) {
        //                     $option->delete();
        //                 }
        //             }
        //             $this_menu->delete();
        //         }
        //     }
        //     $module->delete();
        // }

        return view('setups::modules.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setups::modules.create');
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
            'name' => 'required|unique:modules',
            'route' => 'required|unique:modules'
        ]);

        $role=new Module();
        $role->fill($request->all());
        $role->save();

        return is_save($role,'Module Has been Added.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('setups::modules.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'module' => Module::findOrFail($id)
        ];
        return view('setups::modules.edit',$data);
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
            'route' => 'required',
            'status' => 'required'
        ]);

        $role=Module::findOrFail($id);
        $role->fill($request->all());
        $role->save();

        return is_save($role,'Module has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $role=Module::find($id)->delete();
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
