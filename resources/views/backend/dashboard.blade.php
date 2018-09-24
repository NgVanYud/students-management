@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('strings.backend.dashboard.welcome') }} {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-block">
                    {{--{!! __('strings.backend.welcome') !!}--}}
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="card text-white bg-primary o-hidden">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                    <div class="mr-5">{{$users_count}} Users!</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="card text-white bg-warning o-hidden">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fas fa-server fa-3x"></i>
                                    </div>
                                    <div class="mr-5">{{$subjects_count}} Subjects!</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="card text-white bg-success o-hidden">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fas fa-question-circle fa-3x"></i>
                                    </div>
                                    <div class="mr-5">{{$questions_count}} Questions!</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 mb-5">
                            <div class="card text-white bg-danger o-hidden">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fas fa-book fa-3x"></i>
                                    </div>
                                    <div class="mr-5">
                                        {{$examinations_count}} Examinations!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--card-block-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
