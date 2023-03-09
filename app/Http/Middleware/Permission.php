<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Permission
{
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->user()){
            $url=this_url();
            if(!in_array($url,freeLinks())){
    
                $proceed=true;
                if(!$request->user()->role){
                    $proceed=false;
                }
    
                $links=explode('/',$url);
                if(isset($links[0])){
                    if(!checkPermission(getModule($links[0]) ? getModule($links[0])->id : '',$request->user()->role->permissions,'modules')){
                        $proceed=false;
                    }
                }
    
                if(isset($links[1])){
                    if(!checkPermission(getMenu($links[1]) ? getMenu($links[1])->id : '',$request->user()->role->permissions,'menu') && !checkPermission(getSubmenu($links[1]) ? getSubmenu($links[1])->id : '',$request->user()->role->permissions,'submenu')){
                        $proceed=false;
                    }
                }
    
                if(!$proceed){
                    session()->flash('danger',"Whoops! You don't have the permission to visit the page.");
                    return redirect('dashboard');
                }
            }
        }

        return $next($request);
    }
}
