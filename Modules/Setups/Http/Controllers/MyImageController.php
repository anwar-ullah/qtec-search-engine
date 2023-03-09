<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use \App\User;

class MyImageController extends Controller
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
        return view('setups::myImage.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image'],
        ]);

        $user = auth()->user();

        $fileInfo=fileInfo($request->file);
        $name=$user->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
        $upload=fileUpload($request->file,'user-images',$name);
        if($upload){
           if(!empty($user->image)){
                fileDelete('user-images/'.$user->image);
           }

           $user->image=$name;
           $user->save();
           if($user){
             success('Your image has been uploaded.');
           }else{
             whopps();
           }
        }else{
            whoops('Image upload failed!');
        }

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
