@extends('public.master')
@section('title', '作品详情')
@section('left')
<div class="fl left">
	<div class="left-content">
		<div class="col-main">
			<ul class="author-item">
				<li>
					<div class="cont">
						@if ($opus_data->img_url)
							<div class="img">
								<img style="width: 100%;" src="{{$opus_data->img_url}}" alt="{{$opus_data->title}}">
							</div>
						@endif
						<div class="name-desc">
							<a href="#" class="author-name" style="color: #0F0F0F; cursor: text;"><b>{{$opus_data->title}}</b></a>
							<div class="author-desc">
								@php
									echo htmlspecialchars_decode($opus_data->content);
								@endphp
							</div>
						</div>
					</div>
				</li>
				@foreach ($info_data as $vo)
					@if ($vo->opus_other_short)
						@if ($vo->opus_other)
							<li>
								<div class="cont">
									<div class="name-desc">
										
												<div class="author-desc" id="long_{{$loop->iteration}}">
													@php
														echo htmlspecialchars_decode($vo->opus_other_short);
													@endphp
												</div>
												<div class="author-desc" id="long_{{$loop->iteration}}" style="display: none;">
													@php
														echo htmlspecialchars_decode($vo->opus_other);
													@endphp
												</div>
											
									</div>
								</div>
							</li>
						@endif
					@endif
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection
