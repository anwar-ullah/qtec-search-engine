<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DBBackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }
    
    public function index()
    {
        $data = [
            'files' => \File::allFiles(storage_path('app/backups'))
        ];

        return view('setups::dbBackups.index', $data);
    }

    public function create()
    {
        \Artisan::call("backup:mysql-dump", ['filename' => \Str::slug(systemInformation()->name).'-('.date('Y-m-d g-i-s a').')']);

        session()->flash('success','Databse Backup Successful.');
        return redirect('setups/database-backups');
    }

    public function show($name)
    {
        $path = storage_path('app/backups/'.$name);
        if (file_exists($path)) {
            return \Response::download($path);
        }

        whoops('File Not Found!');
        return redirect()->back();
    }

    public function edit($name)
    {
        $path = storage_path('app/backups/'.$name);
        if (file_exists($path)) {
            unlink($path);
            success('File has been deleted');
            return redirect()->back();
        }

        whoops('File Not Found!');
        return redirect()->back();
    }
}
