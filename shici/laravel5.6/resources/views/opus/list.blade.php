@extends('public.master')
@section('title', '作品列表')
@section('left')
	<div class="fl left">
		<div class="left-content">
			<div class="col-main">
				<ul class="author-item">
					@foreach ($list_data as $list)
						<li>
							<div class="cont">
								@if ($list->img_url)
									<div class="img">
										<a href="/Opus/detail_{{$list->id}}"><img style="width: 100%" src="{{$list->img_url}}" alt="{{$list->title}}"></a>
									</div>
								@endif
								<div class="name-desc">
									<a href="/Opus/detail_{{$list->id}}" class="author-name">{{$list->title}}</a>
									<div class="year"><a href="">{{$list->f_year}}</a>：<a href="">{{$list->author_name}}</a> </div>
									<div class="author-desc">
										@php
											echo htmlspecialchars_decode($list->content);
										@endphp
									</div>
								</div>
							</div>
						</li>
					@endforeach
				</ul>
				<div class="page_info">
					<div>  
                        <a class="next" href="/Opus?page=1">首页</a> 
                        @if ($list_data->currentPage() > 1)
                            <a class="next" href="/Opus?page={{$list_data->currentPage()-1}}">上一页</a> 
                        @endif
                        <span class="current">{{$list_data->currentPage()}}</span>
                        @if ($list_data->currentPage() < $list_data->lastPage())
                            <a class="next" href="/Opus?page={{$list_data->currentPage()+1}}">下一页</a> 
                        @endif
                        <a class="end" href="/Opus?page={{$list_data->lastPage()}}">末页</a>
                    </div>
				</div>
			</div>
		</div>
	</div>
@endsection
