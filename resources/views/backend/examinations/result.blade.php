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
                        {{ __('labels.backend.examinations.management') }}
                        <small class="text-muted">{{ __('labels.backend.examinations.result') }}</small>
                    </h4>
                    <h5 class="mt-2">
                        {{$examination->name}}
                    </h5>
                </div><!--col-->

            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                {{--<th>{{ __('labels.backend.examinations.table.code') }}</th>--}}
                                <th>{{ __('labels.backend.examinations.table.num') }}</th>
                                <th>{{ __('labels.backend.examinations.table.student_name') }}</th>
                                <th>{{ __('labels.backend.examinations.table.code') }}</th>
                                <th>{{ __('labels.backend.examinations.table.test') }}</th>
                                <th>{{ __('labels.backend.examinations.table.score') }}</th>
{{--                                <th>{{ __('labels.backend.examinations.table.proctors_students_tests_questions_time') }}</th>--}}
                                <th>{{ __('labels.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tests as $test)
                                @php $students = $test->students; @endphp
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ ($loop->index) + 1 }}</td>
                                        <td>{{ $student->full_name }}</td>
                                        <td>{{ $student->code }}</td>
                                        <td>{{ $test->code }}</td>
                                        <td>{{ $student->result->correct_ans }}/{{$test->num_questions}}</td>
                                        <td>
                                            {{--{!! $test->print_result_button !!}--}}
                                            <a href="{{route('admin.examination.print_result', [$examination, $test, $student])}}" class="btn btn-primary">
                                                <i class="fas fa-id-card" data-toggle="tooltip" data-placement="top" title="Print Result"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {{--{!! $examinations->total() !!} {{ trans_choice('labels.backend.examinations.table.total', $examinations->total()) }}--}}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
{{--                        {!! $examinations->render() !!}--}}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
