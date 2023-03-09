<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th style="width: 20%;">Status</th>
			<th style="width: 40%">Comment</th>
			<th style="width: 15%;">Updated By</th>
			<th style="width: 25%;">Datetime</th>
		</tr>
	</thead>
	<tbody>
		@if($lead->histories->count() > 0)
		@foreach($lead->histories as $key => $history)
		<tr>
			<td>{{ ucwords(str_replace('-', ' ', $history->status)) }}</td>
			<td>{{ $history->comment }}</td>
			<td>{{ $history->user->name }}</td>
			<td>{{ date('Y-m-d g:i a', strtotime($history->created_at)) }}</td>
		</tr>
		@endforeach
		@endif
	</tbody>
</table>