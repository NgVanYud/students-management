@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.examinations.all'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.examination.create_test_num', $examination))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.examinations.management') }}
                        <small class="text-muted">{{ __('labels.backend.examinations.test_num') }}</small>
                    </h4>
                    <h5 class="mt-2">
                        <a class="text-muted" href="{{route('admin.examination.show', $examination)}}" alt="">{{$examination->name}}</a>
                    </h5>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4">
                <div class="col">

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.test_num'))
                            ->class('col-md-2 form-control-label')
                            ->for('test_num') }}

                        <div class="col-md-10">
                            {{ html()->text('test_num')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.examinations.test_num'))
                                ->attribute('maxlength', 3)
                                ->value(isset($examination->test_num)? $examination->test_num : old('timeout'))
                                ->required() }}
                            <p class="text-danger">
                                <small>
                                    <em>
                                        * This input to set number of test for this examination. After setted,
                                        system will create different tests and attach for certain students!!!
                                    </em>
                                </small>
                            </p>
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
