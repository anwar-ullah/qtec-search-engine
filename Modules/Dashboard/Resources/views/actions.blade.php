<a class="btn btn-sm btn-info text-white" onclick="Show('Lead History #{{ $lead->id }}', '{{ url('dashboard?lead-history='.$lead->id) }}')"><i class="fas fa-history text-white"></i>&nbsp;History</a>

@php
	$show = true;
	if(in_array(auth()->user()->role_id, [1, 2])){
		if($lead->status != "requested-for-confirmation"){
			$show = false;
		}
	}else{
		if(in_array($lead->status, ["requested-for-confirmation", 'confirmed'])){
			$show = false;
		}
	}
@endphp

@if($show)
	<a class="btn btn-sm btn-success text-white" onclick="Show('Update Lead Status #{{ $lead->id }}', '{{ url('dashboard?lead-status='.$lead->id) }}')"><i class="fas fa-edit text-white"></i>&nbsp;Update Status</a>
@endif