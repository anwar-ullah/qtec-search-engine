<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use \Yajra\DataTables\Datatables;

use \App\Models\User;
use \Modules\Setups\Entities\Role;

class AdminController extends Controller
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
            'admins' => User::where('admin', (in_array(auth()->user()->role_id, [1,2]) ? 1 : 0))
                        ->get(),
        ];

        return view('setups::admins.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'text' => auth()->user()->role_id == 4 ? 'user' : 'admin',
            'roles' => Role::where('status',1)
                        ->when(auth()->user()->role->is_main == 0,function($query){
                            return $query->where('is_main',0)->whereIn('id',json_decode(auth()->user()->role->sub_roles));
                        })->get(),
        ];
        return view('setups::admins.create',$data);
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
            'email' => 'required|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => 'required',
        ]);

        $admin = new User();
        $admin->fill($request->all());
        $admin->email = $request->email;
        $admin->username = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->admin = $request->role_id != 3 ? 1 : 0;
        $admin->added_by = auth()->user()->id;
        $admin->gender = 1;
        $admin->save();

        systemUpdated();

        return is_save($admin,'Admin Has been Added.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($info)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'text' => auth()->user()->role_id == 4 ? 'user' : 'admin',
            'roles' => Role::where('status',1)
                        ->when(auth()->user()->role->is_main == 0,function($query){
                            return $query->where('is_main',0)->whereIn('id',json_decode(auth()->user()->role->sub_roles));
                        })->get(),
            'admin' => User::findOrFail($id)
        ];
        return view('setups::admins.edit',$data);
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
            'role_id' => 'required',
            'status' => 'required'
        ]);

        $admin = User::findOrFail($id);
        $admin->fill($request->all());
        $admin->save();

        systemUpdated();

        return is_save($admin,'Admin has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $admin = User::find($id)->delete();
        if($admin){
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
