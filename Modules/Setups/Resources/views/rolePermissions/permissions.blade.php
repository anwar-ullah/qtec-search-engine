<style type="text/css" media="screen">
	.role-permission-ul{
		list-style: none !important;
	}

	label{
		cursor: pointer;
	}

	input[type='checkbox'] {
		cursor: pointer;
	}
</style>

@if(isset($modules[0]))
@foreach($modules as $key => $module)
@if(auth()->user()->role->is_main == 1 || checkPermission($module->id,auth()->user()->role->permissions,'modules'))
	<div class="col-md-12" style="padding-left: 22px !important;">	
		<h4 style="margin-bottom: 0px !important;padding-left: 5px">
			<label>
				<div class="icheck-primary d-inline">
				    <input type="checkbox" id="module-{{$module->id}}" class="module" name="modules[]" value="{{$module->id}}" style="transform: scale(2,2);" {{(checkPermission($module->id,$role->permissions,'modules')) ? 'checked' : ''}} onchange="modifyCheckboxes()">
				    <label for="module-{{$module->id}}" class="text-primary">
				    	{{$module->name}}
				    </label>
				</div>
			</label>
		</h4>
		<hr style="margin-top: 5px !important">
		<div class="row">
			@if(isset($module->menu[0]))
			@foreach($module->menu as $key => $menu)
			@if(auth()->user()->role->is_main == 1 || checkPermission($menu->id,auth()->user()->role->permissions,'menu'))
				<div class="col-md-3">
					<ul class="role-permission-ul">
						<li>
							<h5>
								<label>
									<div class="icheck-success d-inline">
									    <input type="checkbox" id="menu-{{$menu->id}}" name="menu[]" class="menu module-menu-{{$module->id}}" value="{{$menu->id}}" style="transform: scale(1.75,1.75);" {{(checkPermission($menu->id,$role->permissions,'menu')) ? 'checked' : ''}}  onchange="modifyCheckboxes()">
									    <label for="menu-{{$menu->id}}" class="text-success">
									    	{{$menu->name}}
									    </label>
									</div>
								</label>
							</h5>
							@if(isset($menu->submenu[0]))
							@foreach($menu->submenu as $key => $submenu)
							@if(auth()->user()->role->is_main == 1 || checkPermission($submenu->id,auth()->user()->role->permissions,'submenu'))
								<ul class="role-permission-ul">
									<li>
										<h6>
											<label>
												<div class="icheck-info d-inline">
												    <input type="checkbox" name="submenu[]" id="submenu-{{$submenu->id}}"  class="submenu menu-submenu-{{$menu->id}} module-submenu-{{$module->id}}" value="{{$submenu->id}}" style="transform: scale(1.5,1.5);" {{(checkPermission($submenu->id,$role->permissions,'submenu')) ? 'checked' : ''}} onchange="modifyCheckboxes()">
												    <label for="submenu-{{$submenu->id}}" class="text-info">
												    	{{$submenu->name}}
												    </label>
												</div>
											</label>
										</h6>
										@if(isset($submenu->options[0]))
										<ul class="role-permission-ul">
											@foreach($submenu->options as $key => $option)
											@if(auth()->user()->role->is_main == 1 || checkPermission($option->id,auth()->user()->role->permissions,'options'))
												<li>
													<label>
														<div class="icheck-secondary d-inline">
														    <input type="checkbox" id="option-{{$option->id}}" name="options[]" class="option menu-option-{{$menu->id}} submenu-option-{{$submenu->id}} module-option-{{$module->id}}" value="{{$option->id}}" {{(checkPermission($option->id,$role->permissions,'options')) ? 'checked' : ''}}  onchange="modifyCheckboxes()">
														    <label for="option-{{$option->id}}" class="text-secondary">
														    	{{$option->name}}
														    </label>
														</div>
													</label>
												</li>
											@endif
											@endforeach
										</ul>
										@endif
									</li>
								</ul>
							@endif
							@endforeach
							@endif

							@if(isset($menu->options[0]))
								<ul class="role-permission-ul">
									@foreach($menu->options as $key => $option)
									@if(auth()->user()->role->is_main == 1 || checkPermission($option->id,auth()->user()->role->permissions,'options'))
										<li>
											<label>
												<div class="icheck-secondary d-inline">
												    <input type="checkbox" id="option-{{$option->id}}" name="options[]" class="option menu-option-{{$menu->id}} module-option-{{$module->id}}" value="{{$option->id}}" {{(checkPermission($option->id,$role->permissions,'options')) ? 'checked' : ''}}  onchange="modifyCheckboxes()">
												    <label for="option-{{$option->id}}" class="text-secondary">
												    	{{$option->name}}
												    </label>
												</div>
											</label>
										</li>
									@endif
									@endforeach
								</ul>
							@endif
						</li>
					</ul>
				</div>
			@endif
			@endforeach
			@endif
		</div>
	</div>
@endif
@endforeach
@endif