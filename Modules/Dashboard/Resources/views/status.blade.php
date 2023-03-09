<form action="{{ url('dashboard') }}" method="get" accept-charset="utf-8" id="status-form">
<input type="hidden" name="update-lead-status" value="{{ $lead->id }}">
	<div class="form-group">
		<label for="status"><strong>Status</strong></label>
		<select name="status" id="status" class="form-control select2bs4">
			@if(in_array(auth()->user()->role_id, [1, 2]))
				<option value="confirmed" {{ $lead->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
			@else
				<option value="new" {{ $lead->status == 'new' ? 'selected' : '' }}>New</option>
				<option value="hold" {{ $lead->status == 'hold' ? 'selected' : '' }}>Hold</option>
				<option value="trash" {{ $lead->status == 'trash' ? 'selected' : '' }}>Trash</option>
				<option value="cancelled" {{ $lead->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
				<option value="requested-for-confirmation" {{ $lead->status == 'requested-for-confirmation' ? 'selected' : '' }}>Requested for Confirmation</option>
			@endif
		</select>
	</div>
	<div class="form-group">
		<label for="comment"><strong>Comment</strong></label>
		<textarea name="comment" name="comment" id="comment" class="form-control" style="height: 150px;resize: none"></textarea>
	</div>
	<button type="submit" class="btn btn-primary status-button"><i class="fa fa-save"></i>&nbsp; Update Lead Status</button>
</form>
<script type="text/javascript">
    $('.select2bs4').select2({
    	theme: 'bootstrap4'
    });

    $(document).ready(function() {
    	var form = $('#status-form');
    	var button = $('.status-button');
    	var button_content = button.html();

    	form.submit(function(event) {
    		event.preventDefault();
    		button.html('<i class="fas fa-spinner"></i>&nbsp;Please wait...').prop('disabled', true);

    		$.ajax({
    			url: form.attr('action'),
    			type: form.attr('method'),
    			dataType: 'json',
    			data: form.serializeArray(),
    		})
    		.done(function(response) {
    			button.html(button_content).prop('disabled', false);
    			if(response.success){
    				notify(response.message, 'success');
    				reloadDatatable();
    			}else{
    				notify(response.message, 'danger');
    			}
    		})
    		.fail(function(response) {
    			button.html(button_content).prop('disabled', false);
    			$.each(response.responseJSON.errors, function(index, val) {
    				notify(val[0],'danger');
    			});
    		});
    	});
    });
</script>