@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.examinations.all'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.examination.store_format_test', $examination))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.examinations.management') }}
                        <small class="text-muted">{{ __('labels.backend.examinations.format_test') }}</small>
                    </h4>
                    <h5 class="mt-2">
                        <a class="text-muted" href="{{route('admin.examination.show', $examination)}}" alt="">{{$examination->name}}</a>
                    </h5>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4">
                <div class="col">
                    @php
                        $subject = $examination->subject;
                        $chapters = $subject->chapters;
                        $format_test = json_decode($examination->format_test, true);
                    @endphp

                    {{--{{dd($format_test)}}--}}

                    <div class="form-group row">
                        {{ html()->label('Chapters List')
                            ->class('col-md-7 form-control-label font-weight-bold')}}
                        {{ html()->label('Number of Questions')
                            ->class('col-md-2 form-control-label font-weight-bold')}}
                        {{ html()->label('(Total: '.$examination->question_num. ')')
                            ->class('col-md-2 form-control-label font-weight-bold text-primary text-right')->id('num_of_questions')}}
                    </div><!--form-group-->

                    @foreach($chapters as $chapter)
                        <div class="form-group row">
                            {{ html()->label((($loop->index) + 1).'. '.$chapter->name)
                                ->class('col-md-7 form-control-label')
                                ->for($chapter->slug) }}

                            <div class="col-md-4">
                                {{ html()->text($chapter->slug)
                                    ->class('form-control')
                                    ->placeholder($chapter->name)
                                    ->attribute('maxlength', 3)
                                    ->value(isset($format_test)? $format_test[$chapter->slug] : old($chapter->slug))
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->
                    @endforeach
                    <hr>
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.timeout'))
                            ->class('col-md-7 form-control-label')
                            ->for('timeout') }}

                        <div class="col-md-4">
                            {{ html()->text('timeout')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.examinations.timeout'))
                                ->attribute('maxlength', 3)
                                ->value(isset($examination->timeout)? $examination->timeout : old('timeout'))
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.examination.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection
