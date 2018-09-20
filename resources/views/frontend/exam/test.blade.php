@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. __('navs.frontend.dashboard') )

@section('content')
{{--{{ html()->form('POST', route('frontend.student.submit_test', [$logged_in_user, $examination]))--}}
    {{--->class('form-horizontal')--}}
    {{--->name('formTest')--}}
    {{--->open()}}--}}
<form action="{{route('frontend.student.submit_test', [$logged_in_user, $examination])}}" method="POST" class="form-horizontal" name="formTest">
{{csrf_field()}}
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-list" ></i> {{ __('navs.frontend.test') }} : {{ $examination->name }}
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    @php $questions = $test->questions; @endphp

                    @foreach($questions as $question)
                        <div class="col-xs-12 form-group">
                            <div class="form-group">
                                <strong>Question {{ ($loop->index) + 1 }}.<br />{!! nl2br($question->content) !!}</strong>

                                <input type="hidden"
                                       name="questions[{{$loop->index}}]"
                                       value="{{ $question->id }}">
                                @foreach($question->answers as $option)
                                    <br>
                                    <label class="radio-inline">
                                        <input
                                                type="checkbox"
                                                name="answers[{{ $question->id }}][]"
                                                value="{{ $option->id }}">
                                        {{ $option->content }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>

                <div class="card-footer">
                    <div class="row">

                        <div class="col text-right">
                            {{ form_submit(__('buttons.backend.examinations.submit')) }}
                        </div><!--col-->
                    </div><!--row-->
                </div><!--card-footer-->

            </div> <!-- card-body -->
        </div><!-- card -->
    </div><!-- row -->
</form>
@endsection

@push('after-scripts')
    {!! script(asset('plugins/countdown/jquery.countdownTimer.min.js')) !!}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#countdown").countdowntimer({
                minutes : Math.floor({{$timeout/60}}),
                seconds : '{{$timeout%60}}',
            });
        });

        window.onload=function(){
            window.setTimeout(function() { document.formTest.submit(); }, {{$timeout*1000}});
        };
    </script>
@endpush
