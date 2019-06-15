@extends('public.master')
@section('title', '古文列表')
@section('left')
<div id="book_detail_l" class="left-content book-detail">
	<div class="col-main">
		<ul class="author-item">
			<li>
				<div class="cont">
					<div class="name-desc">
						<a href="#" class="author-name" style="color: #0F0F0F; cursor: text;"><b>{{$article_data->title}}</b></a>
						<div class="author-desc">
						@php
							echo htmlspecialchars_decode($article_data->content);
						@endphp
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>
@endsection
