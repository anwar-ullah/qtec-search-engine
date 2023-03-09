<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Menu;
use Modules\Setups\Entities\Submenu;

class SubmenuController extends Controller
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
        return $this->show('0');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
        ];
        return view('setups::submenu.create',$data);
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
            'menu_id' => 'required',
            'name' => 'required',
            'route' => 'required',
        ]);

        $role=new Submenu();
        $role->fill($request->all());
        $role->save();

        return is_save($role,'Submenu Has been Added.');
    }

    public function getMenu($module_id){
        return Menu::where('status',1)
            ->when($module_id>0,function($query) use($module_id){
                return $query->where('module_id',$module_id);
            })
            ->orderBy('serial','asc')
            ->orderBy('name','asc')
            ->get();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($menu_id)
    {
        $data = [
            'menu_id' => $menu_id,
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
            'submenu' => Submenu::orderBy('serial','asc')
                        ->when($menu_id>0,function($query) use($menu_id){
                            return$query->where('menu_id',$menu_id);
                        })
                        ->orderBy('serial','asc')
                        ->get()
        ];
        return view('setups::submenu.index',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
            'submenu' => Submenu::findOrFail($id)
        ];
        return view('setups::submenu.edit',$data);
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
            'menu_id' => 'required',
            'name' => 'required',
            'route' => 'required',
            'status' => 'required'
        ]);

        $role=Submenu::findOrFail($id);
        $role->fill($request->all());
        $role->save();

        return is_save($role,'Submenu has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $role=Submenu::find($id)->delete();
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
