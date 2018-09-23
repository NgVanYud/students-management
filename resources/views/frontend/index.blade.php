@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('navs.general.home'))

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-home"></i> {{ __('navs.general.home') }}
                </div>
                <div class="card-body">
                    <h5>
                        {{ __('strings.frontend.welcome_to', ['place' => app_name()]) }}
                    </h5>
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->

    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users"></i> {{ __('navs.general.group') }}
                </div>
                <div class="card-body">
                    <h5>
                        List of member:
                    </h5>
                    <ul>
                        <li><strong>Nguyễn Văn Duy.</strong></li>
                        <li><strong>Lê Việt Dũng.</strong></li>
                        <li><strong>Bùi Anh Tuấn.</strong></li>
                        <li><strong>Bùi Xuân Tài.</strong></li>
                        <li><strong>Lê Thanh Lĩnh.</strong></li>
                        <li><strong>Bùi Văn Nguyên.</strong></li>
                        <li><strong>Vũ Minh Tú.</strong></li>
                        <li><strong>Đoàn Hương Ly.</strong></li>
                        <li><strong>Hà Thị Quyên.</strong></li>
                    </ul>
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->

    {{--<div class="row mb-4">--}}
        {{--<div class="col">--}}
            {{--<example-component></example-component>--}}
        {{--</div><!--col-->--}}
    {{--</div><!--row-->--}}

    {{--<div class="row">--}}
        {{--<div class="col">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">--}}
                    {{--<i class="fab fa-font-awesome-flag"></i> Font Awesome {{ __('strings.frontend.test') }}--}}
                {{--</div>--}}
                {{--<div class="card-body">--}}
                    {{--<i class="fas fa-home"></i>--}}
                    {{--<i class="fab fa-facebook"></i>--}}
                    {{--<i class="fab fa-twitter"></i>--}}
                    {{--<i class="fab fa-pinterest"></i>--}}
                {{--</div><!--card-body-->--}}
            {{--</div><!--card-->--}}
        {{--</div><!--col-->--}}
    {{--</div><!--row-->--}}
@endsection
