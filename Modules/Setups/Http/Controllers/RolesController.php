<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Role;

class RolesController extends Controller
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
                        ->when(auth()->user()->role->is_main == 0,function($query){
                            return $query->where('is_main',0)->whereIn('id',json_decode(auth()->user()->role->sub_roles));
                        })
                        ->get()
        ];
        return view('setups::roles.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'roles' => Role::where('status',1)
                        ->when(auth()->user()->role->is_main == 0,function($query){
                            return $query->where('is_main',0);
                        })
                        ->whereNotIn('id',[auth()->user()->role_id])
                        ->get()
        ];
        return view('setups::roles.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        $role=new Role();
        $role->fill($request->all());
        $role->sub_roles=json_encode(isset($request->sub_roles[0]) ? $request->sub_roles : array());
        $role->permissions=json_encode(array());
        $role->save();

        return is_save($role,'Role Has been Added.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('setups::roles.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'roles' => Role::where('status',1)
                        ->when(auth()->user()->role->is_main == 0,function($query){
                            return $query->where('is_main',0);
                        })
                        ->whereNotIn('id',[auth()->user()->role_id,$id])
                        ->get(),
            'role' => Role::findOrFail($id)
        ];
        return view('setups::roles.edit',$data);
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

        $role=Role::findOrFail($id);
        $role->fill($request->all());
        $role->sub_roles=json_encode(isset($request->sub_roles[0]) ? $request->sub_roles : array());
        $role->save();

        return is_save($role,'Role has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        if(in_array($id, [1,2,3])){
            return response()->json([
                'success' => false,
                'message' => 'This Role Cannot be deleted!'
            ]);
        }

        $role=Role::find($id)->delete();
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
