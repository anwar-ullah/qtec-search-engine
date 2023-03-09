<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\SystemInformation;

class SystemInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }
    
    public function index()
    {
        $data = [
            'information' => SystemInformation::find(1)
        ];
        return view('setups::systemInformation.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'twitter' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'skype' => 'required',
            'linked_in' => 'required',
        ]);

        $information = SystemInformation::find(1);
        $information->fill($request->all());
        $information->save();

        if($information){
            if($request->hasFile('logo_file')){
                $fileInfo=fileInfo($request->logo_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->logo_file,'system-images/logos',$name);
                if($upload){
                   if(!empty($information->logo)){
                        fileDelete('system-images/logos/'.$information->logo);
                   }
                   $information->logo=$name;
                   $information->save();
                }
            }

            if($request->hasFile('icon_file')){
                $fileInfo=fileInfo($request->icon_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->icon_file,'system-images/icons',$name);
                if($upload){
                    if(!empty($information->icon)){
                        fileDelete('system-images/icons/'.$information->icon);
                    }
                   $information->icon=$name;
                   $information->save();
                }
            }
        }

        systemUpdated();

        return is_save($information,'System Information Has been updated.');
    }
}
