@extends('public.master')
@section('title', '诗人详情')
@section('left')
		<div class="fl left">
			<div class="left-content">
				<div class="col-main">
					<ul class="author-item">
						<li>
							<div class="cont">
								@isset ($author_data->img_url)
									<div class="img">
										<img src="{{$author_data->img_url}}" alt="{{$author_data->author_name}}">
									</div>
								@endisset
								<div class="name-desc">
									<a href="#" class="author-name" style="color: #0F0F0F; cursor: text;"><b>{{$author_data->author_name}}</b></a>
									<div class="author-desc">
										{{$author_data->author_desc}}
									</div>
								</div>
							</div>
						</li>
						@isset ($info_data)
                    		@foreach ($info_data as $vo)
								<li>
									<div class="cont">
										<div class="name-desc">
											<div class="author-desc" id="short_{{$loop->iteration}}">
												{!! $vo->author_other_short !!}
											</div>
											<div class="author-desc" id="long_{{$loop->iteration}}" style="display: none;">
												{!!$vo->author_other !!}
											</div>
										</div>
									</div>
								</li>
							@endforeach
						@endisset
					</ul>
				</div>
			</div>
		</div>
@endsection
