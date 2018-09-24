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
                    <h4>
                        List of members:
                    </h4>
                    <div class="row d-flex justify-content-center text-info" style="font-size: 1.5rem;">
                        <div class="col-md-4">
                            <ul>
                                <li>Nguyễn Văn Duy.</li>
                                <li>Lê Việt Dũng.</li>
                                <li>Bùi Anh Tuấn.</li>
                                <li>Bùi Xuân Tài.</li>
                                <li>Lê Thanh Lĩnh.</li>
                            </ul>
                        </div>

                        <div class="col-md-4">
                            <ul>
                                <li>Bùi Văn Nguyên.</li>
                                <li>Vũ Minh Tú.</li>
                                <li>Đoàn Hương Ly.</li>
                                <li>Hà Thị Quyên.</li>
                            </ul>
                        </div>
                    </div>
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
