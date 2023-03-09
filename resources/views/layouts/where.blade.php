@php
	$url=this_url();
	$links=explode('/',$url);
@endphp

@if(isset($links[0]) && getModule($links[0]))
	<li class="breadcrumb-item">{{getModule($links[0])->name}}</li>
@endif

@if(isset($links[1]))
	@if(getMenu($links[1]))
		<li class="breadcrumb-item active"><a href="{{ url($links[0].'/'.$links[1]) }}">{{getMenu($links[1])->name}}</a></li>
	@elseif(getSubmenu($links[1]))
		<li class="breadcrumb-item">{{getSubmenu($links[1])->menu->name}}</li>
		<li class="breadcrumb-item active"><a href="{{ url($links[0].'/'.$links[1]) }}">{{getSubmenu($links[1])->name}}</a></li>
	@endif
@endif