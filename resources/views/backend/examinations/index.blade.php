@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.examinations.management'))

@section('breadcrumb-links')
    {{--@include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.examinations.management') }} <small class="text-muted">{{ __('labels.backend.examinations.all') }}</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @if($logged_in_user->isAdmin())
                        @include('backend.examinations.includes.examination-header-buttons')
                    @endif
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                {{--<th>{{ __('labels.backend.examinations.table.code') }}</th>--}}
                                <th>{{ __('labels.backend.examinations.table.name') }}</th>
                                <th>{{ __('labels.backend.examinations.table.subject') }}</th>
                                @if($logged_in_user->isAdmin())
                                    <th>{{ __('labels.backend.examinations.table.actived') }}</th>
                                @endif
                                @if($logged_in_user->isProctor())
                                    <th>{{ __('labels.backend.examinations.table.published') }}</th>
                                @endif
                                <th>{{ __('labels.backend.examinations.table.begin_time') }}</th>
                                <th>{{ __('labels.backend.examinations.table.proctors_students_tests_questions_time') }}</th>
                                @if(!$logged_in_user->isProctor() || $logged_in_user->isAdmin())
                                    <th>{{ __('labels.general.actions') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($examinations as $examination)
                                    <tr>
                                        {{--<td>{{ $examination->code }}</td>--}}
                                        <td>{{ $examination->name }}</td>
                                        <td>{{ $examination->subject->name }}</td>
                                        @if($logged_in_user->isAdmin())
                                            <td>{!! $examination->actived_label !!}</td>
                                        @endif
                                        @if($logged_in_user->isProctorForExamination($examination))
                                            <td>{!! $examination->published_label !!}</td>
                                        @endif
                                        <td>{{ $examination->begin_time }}</td>
                                        <td>
                                            {{$examination->number_proctors}}/{{$examination->number_students}}/{{$examination->test_num}}/{{$examination->question_num}}/{{$examination->timeout}}
                                        </td>
                                        @if(!$logged_in_user->isProctor() || $logged_in_user->isAdmin())
                                            <td>{!! $examination->action_buttons !!}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {!! $examinations->total() !!} {{ trans_choice('labels.backend.examinations.table.total', $examinations->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $examinations->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
