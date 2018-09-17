@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.examinations.all'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@push('before-styles')
    {!! style(asset('plugins/select2/css/select2.min.css')) !!}
    {!! style(asset('plugins/summernote/summernote-bs4.css')) !!}

@endpush

@section('content')
<form class="form-horizontal" action="{{ route('admin.examination.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.examinations.management') }}
                        <small class="text-muted">{{ __('labels.backend.examinations.create') }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.name'))
                            ->class('col-md-2 form-control-label')
                            ->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.examinations.name'))
                                ->attribute('maxlength', 191)
                                ->required()}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.code'))
                            ->class('col-md-2 form-control-label')
                            ->for('code') }}

                        <div class="col-md-10">
                            {{ html()->text('code')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.examinations.code'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.subject'))
                            ->class('col-md-2 form-control-label')
                            ->for('subject') }}

                        <div class="col-md-10">
                            {{ html()->select('subject', [null => null])
                                ->options($subjects)
                                ->class('form-control subjects_list')
                                ->required()}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.begin_time'))
                            ->class('col-md-2 form-control-label')
                            ->for('begin_time') }}

                        <div class="col-md-5">
                            {{ html()->date('begin_date')
                                ->class('form-control')
                                ->required()}}

                        </div><!--col-->
                        <div class="col-md-5">
                            {{ html()->time('begin_time')
                                ->class('form-control')
                                ->required()}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.subjects.active'))->class('col-md-2 form-control-label')->for('is_actived') }}

                        <div class="col-md-10">
                            <label class="switch switch-3d switch-primary">
                                {{ html()->checkbox('is_actived')->class('switch-input')->checked(old('is_actived')) }}
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.questions.content'))
                        ->class('col-md-2 form-control-label')->for('content') }}

                        <div class="col-md-10">
                            {{ html()->textarea('content')
                                ->class('form-control text_editor')}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.proctors_file'))
                            ->class('col-md-2 form-control-label')
                            ->for('proctors_file') }}

                        <div class="col-md-10">
                            {{ html()->file('proctors_file')
                                ->class('form-control')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.examinations.students_file'))
                            ->class('col-md-2 form-control-label')
                            ->for('students_file') }}

                        <div class="col-md-10">
                            {{ html()->file('students_file')
                                ->class('form-control')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer clearfix">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.auth.user.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
</form>
@endsection

@push('after-scripts')
    {!! script(asset('plugins/select2/js/select2.min.js')) !!}
    {!! script(asset('plugins/summernote/summernote-bs4.min.js')) !!}

    <script type="text/javascript">

        $(document).ready(function() {

            $(".general_info_list").select2({
                placeholder: "Select a subject",
                closeOnSelect: true
            });

            $('.text_editor').summernote({
                minHeight:200
            });
        });
    </script>
@endpush
