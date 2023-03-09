@php
$links = explode('/',this_url());
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    
    <a href="{{url('dashboard')}}" class="brand-link">
      	
	</a>
	
    <div class="sidebar half-a-second">
        <nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				@php
				$permissions = json_decode(auth()->user()->role->permissions);
				$modules = false;
				if(isset($permissions->modules) && is_array($permissions->modules)){
		    	$modules = \Modules\Setups\Entities\Module::where('status',1)
				->whereIn('id',$permissions->modules)
				->orderBy('serial','asc')
				->orderBy('name','asc')
				->get();
				}
				@endphp
				
				@if($modules && isset($modules[0]))
				@foreach ($modules as $key => $module)
				<li class="nav-item has-treeview {{isset($links[0]) && $module->route == $links[0] ? 'menu-open' : ''}}">
					<a style="cursor: pointer;color: white" class="nav-link">
						<i class="nav-icon text-white {{(!empty($module->icon) ? $module->icon : 'fas fa-chart-pie')}}"></i>
						<p>
							{{$module->name}}
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					@php
					$menus = false;
					if(is_array($permissions->menu)){
			      	$menus = \Modules\Setups\Entities\Menu::where(['module_id'=>$module->id,'status'=>1])
					->whereIn('id',$permissions->menu)
					->orderBy('serial','asc')
					->orderBy('name','asc')
					->get();
					}
					@endphp
					@if($menus && isset($menus[0]))
					<ul class="nav nav-treeview">
						@foreach ($menus as $key => $menu)
						@php
						$submenus = false;
						if(is_array($permissions->submenu)){
		            	$submenus = \Modules\Setups\Entities\Submenu::where(['menu_id'=>$menu->id,'status'=>1])
						->whereIn('id',$permissions->submenu)
						->orderBy('serial','asc')
						->orderBy('name','asc')
						->get();
						}
						
						$open = false;
						if($submenus && isset($links[1]) && $submenus->where('route',$links[1])->count() > 0){
		            	$open = true;
						}
						@endphp
						
						<li class="nav-item {{(isset($menu->submenu[0])) ? 'has-treeview' : ''}}  {{$open ? 'menu-open' : ''}}">
							<a @if($menu->route!='#') href="{{url('/'.$module->route.'/'.$menu->route)}}" @else style="cursor: pointer;" @endif class="nav-link {{isset($links[1]) && $links[1] == $menu->route ? 'bg-primary text-white text-bold' : ''}}">
								&nbsp;&nbsp;
								<i class="nav-icon {{(!empty($menu->icon) ? $menu->icon : 'far fa-circle')}}"></i>
								<p>
									{{$menu->name}}
									{!! (isset($menu->submenu[0])) ? '<i class="right fas fa-angle-left"></i>' : '' !!}
								</p>
							</a>
							@if($submenus && isset($submenus[0]))
							<ul class="nav nav-treeview">
								@foreach ($submenus as $key => $submenu)
								<li class="nav-item">
									<a href="{{url('/'.$module->route.'/'.$submenu->route)}}" class="nav-link {{isset($links[1]) && $links[1] == $submenu->route ? 'bg-primary text-white text-bold' : ''}}">
										&nbsp;&nbsp;&nbsp;&nbsp;
										<i class="nav-icon {{(!empty($submenu->icon) ? $submenu->icon : 'far fa-dot-circle')}}"></i>
										<p>{{$submenu->name}}</p>
									</a>
								</li>
								@endforeach
							</ul>
							@endif
						</li>
						@endforeach
					</ul>
					@endif
				</li>
				@endforeach
				@endif
				
			</ul>
		</nav>
	</div>    
</aside>