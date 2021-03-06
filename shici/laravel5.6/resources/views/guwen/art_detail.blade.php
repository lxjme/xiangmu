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
						<span class="fanyi fr" data-val="1" id="yizhu_btn">译注</span>
						<div class="author-desc">
							{{$article_data->content}}
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>
<div id="book_detail_r" class="fl sidebar-left book-detail-r">
	<div class="right-content fl">
		<div class="bg-f2f1e3 fl-right right-tag">
			<div class="sontitle">
				<b>译文</b>
				<span class="fr quanping" data-val="1" id="fanyi_quanping">全屏</span>
				<div class="soncontent yizhu-content">
					@if ($article_data->fanyi)
						@php
							echo htmlspecialchars_decode($article_data->fanyi);

						@endphp
					@else
						<div style="text-align: center;">暂无译文</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

