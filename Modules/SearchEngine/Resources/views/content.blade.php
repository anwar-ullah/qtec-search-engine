<h5 class="mb-3"><strong>{!! str_replace($search, '<span class="search-text">'.$search.'</span>', $model->title) !!}</strong></h5>

<h5><strong>Fine Points</strong></h5>
<div class="mb-5">{!! str_replace($search, '<span class="search-text">'.$search.'</span>', $model->fine_points) !!}</div>

<h5><strong>Content</strong></h5>
<div>{!! str_replace($search, '<span class="search-text">'.$search.'</span>', $model->content) !!}</div>