@extends('public.master')
@section('title', '诗人列表')
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
                                        <a href="/Author/detail_{{$list->id}}"><img src="{{ str_replace('/U','/u', $list->img_url) }}" alt="{{$list->author_name}}"></a>
                                    </div>    
                                @endif                                     
                                <div class="name-desc">
                                    <a href="/Author/detail_{{$list->id}}" class="author-name">{{ $list->author_name }}</a>
                                    <div class="author-desc">{!! $list->author_desc !!}</div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="page_info">
                    <div>  
                        <a class="next" href="/Author?page=1}}">首页</a> 
                        @if ($list_data->currentPage() > 1)
                            <a class="next" href="/Author?page={{$list_data->currentPage()-1}}">上一页</a> 
                        @endif
                        <span class="current">{{$list_data->currentPage()}}</span>
                        @if ($list_data->currentPage() < $list_data->lastPage())
                            <a class="next" href="/Author?page={{$list_data->currentPage()+1}}">下一页</a> 
                        @endif
                        <a class="end" href="/Author?page={{$list_data->lastPage()}}">末页</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection