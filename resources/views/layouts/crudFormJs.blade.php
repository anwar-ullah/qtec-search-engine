<script type="text/javascript">
	$(document).ready(function() {
		var form = $('#crud-form');
		var button = form.find('.crud-button');
		var buttonContent = button.html();

		form.submit(function(event) {
			event.preventDefault();
			button.prop('disabled', true).html('<i class="fas fa-spinner"></i>&nbsp;Please wait...');

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				dataType: 'json',
				processData: false,
        		contentType: false,
        		data: new FormData(form[0]),
			})
			.done(function(response) {
				if(response.success){
					if($('.datatable-serverside').attr('class')){
						$('#modal').modal('hide');
						notify(response.message, 'success');
						reloadDatatable();
					}else{
						location.reload();
					}
				}else{
					notify(response.message, 'danger');
				}
				button.prop('disabled', false).html(buttonContent);
			})
			.fail(function(response) {
				var errors = '<ul class="pl-3">';
				$.each(response.responseJSON.errors, function(index, val) {
					errors += '<li>'+val[0]+'</li>';
				});
				errors += '</ul>';
				notify(errors, 'danger');

				button.prop('disabled', false).html(buttonContent);
			});
		});
	});
</script>