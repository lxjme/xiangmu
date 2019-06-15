@extends('public.master')
@section('title', '古文列表')
@section('left')
<div class="fl left">
	<div class="left-content">
		<div class="col-main">
			<ul class="author-item">
				@foreach ($list_data as $list)
					<li>
						<div class="cont">
							@if ($list->f_book_fm)
								<div class="img">
									<a href="/Shuji/artList_{{$list->f_id}}"><img style="width: 105px;" src="{{$list->f_book_fm}}" alt="{{$list->f_book_name}}"></a>
								</div>
							@endif
							<div class="name-desc">
								<a href="/Shuji/artList_{{$list->f_id}}" class="author-name">{{$list->f_book_name}}</a>
								<div class="author-desc">
									@php
										echo htmlspecialchars_decode($list->f_book_desc);
									@endphp
								</div>
							</div>
						</div>
					</li>
				@endforeach
			</ul>
			<div class="page_info">
				<div>  
                    <a class="next" href="/Shuji?page=1">首页</a> 
                    @if ($list_data->currentPage() > 1)
                        <a class="next" href="/Shuji?page={{$list_data->currentPage()-1}}">上一页</a> 
                    @endif
                    <span class="current">{{$list_data->currentPage()}}</span>
                    @if ($list_data->currentPage() < $list_data->lastPage())
                        <a class="next" href="/Shuji?page={{$list_data->currentPage()+1}}">下一页</a> 
                    @endif
                    <a class="end" href="/Shuji?page={{$list_data->lastPage()}}">末页</a>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
