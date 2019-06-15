@extends('public.master')
@section('title', '古文列表')
@section('left')
	<div class="fl left">
		<div class="left-content">
			<div class="col-main">
				<ul class="author-item">
					<li>
						<div class="cont">
							@if ($book_res->f_book_fm)
								<div class="img">
									<img src="{{$book_res->f_book_fm}}" alt="{{$book_res->f_book_name}}">
								</div>
							@endif
							<div class="name-desc">
								<a href="#" class="author-name" style="color: #0F0F0F; cursor: text;"><b>{{$book_res->f_book_name}}</b></a>
								<div class="author-desc">
									{{$book_res->f_book_desc}}
								</div>
							</div>
						</div>
					</li>
				</ul>
				<div class="article-list">
					@foreach ($article_list as $vo)
						<dl>
							@isset ($vo['lanmu_name'])
								<dt><b>{{$vo['lanmu_name']}}</b></dt>
							@endisset
							@foreach ($vo['list'] as $sub_vo)
								<dd><a href="/Guwen/artDetail_{{$sub_vo['id']}}">{{$sub_vo['title']}}</a></dd>
							@endforeach
						</dl>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
