@if(isset($searchDataModels[0]))
@foreach($searchDataModels as $key => $model)
<div class="row">
    <div class="col-md-12 mb-5">
        {!! $model->content !!}
        <p><small>Searched by <strong>{{ $model->search->user->name }}</strong> at <strong>{{ date('Y-m-d g:i a', strtotime($model->search->created_at)) }}</strong></small></p>
        {!! $searchDataModels->count() > $key+1 ? '<hr>' : '' !!}
    </div>
</div>
@endforeach
@else
<div class="row">
    <div class="col-md-12">
        <h5 class="text-center text-danger">Whoops! Nothing Found!</h5>
    </div>
</div>
@endif

<div class="row mt-4">
    <div class="col-md-12">
        {{ $searchDataModels->render("pagination::bootstrap-4") }}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.each($('.page-link'), function(index, val) {
            var link = $(this);
            link.click(function(event) {
                event.preventDefault();

                var form = $('#statistics-form');
                var button = form.find('.statistics-button');
                var buttonContent = button.html();
                searchModels(form, button, buttonContent, link.attr('href').split('page=')[1]);
            });
        });
    });
</script>