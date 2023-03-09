<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Role;

class RolePermissionsController extends Controller
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
            'roles' => Role::where('status',1)
                        ->when(auth()->user()->role->is_main == 0,function($query,$role_array){
                            return $query->where('is_main',0)->whereIn('id',json_decode(auth()->user()->role->sub_roles));
                        })->get()
        ];

        return view('setups::rolePermissions.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
        ]);

        $permissions=array(
            'modules' => $request->modules,
            'menu' => $request->menu,
            'submenu' => $request->submenu,
            'options' => $request->options,
        );

        $role=Role::findOrFail($request->role_id);
        $role->permissions=json_encode($permissions);
        $role->save();

        return is_save($role,'Role Permissions Has been Updated.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($role_id)
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
            'role' => Role::findOrFail($role_id),
        ];

        return view('setups::rolePermissions.permissions',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
