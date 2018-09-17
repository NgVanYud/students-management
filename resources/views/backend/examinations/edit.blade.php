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

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['general_info'])) ? 'active' : ''}}" data-toggle="tab" href="#general_info" role="tab" aria-controls="general_info" aria-expanded="{{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['general_info']))}}"><i class="fas fa-book"></i> {{ __('labels.backend.examinations.tabs.titles.general_info') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['proctors'])) ? 'active' : ''}}" data-toggle="tab" href="#proctor" role="tab" aria-controls="proctors" aria-expanded="{{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['proctors']))}}"><i class="fas fa-book"></i> {{ __('labels.backend.examinations.tabs.titles.proctors') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['students'])) ? 'active' : ''}}" data-toggle="tab" href="#student" role="tab" aria-controls="students" aria-expanded="{{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['students']))}}"><i class="fas fa-book"></i> {{ __('labels.backend.examinations.tabs.titles.students') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane {{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['general_info'])) ? 'active' : ''}}" id="general_info" role="tabpanel" aria-expanded="{{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['general_info']))}}">
                            @include('backend.examinations.edit.tabs.general-info')
                        </div><!--tab-->

                        <div class="tab-pane {{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['proctors'])) ? 'active' : ''}}" id="proctor" role="tabpanel" aria-expanded="{{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['proctors']))}}">
                            @include('backend.examinations.edit.tabs.proctors')
                        </div><!--tab-->

                        <div class="tab-pane {{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['students'])) ? 'active' : ''}}" id="student" role="tabpanel" aria-expanded="{{(isset($tab_type) && ($tab_type == ExaminationModel::TAB_TYPES['students']))}}">
                            @include('backend.examinations.edit.tabs.students')
                        </div><!--tab-->
                    </div><!--tab-content-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection

@push('after-scripts')
    {!! script(asset('plugins/select2/js/select2.min.js')) !!}
    {!! script(asset('plugins/summernote/summernote-bs4.min.js')) !!}

    <script type="text/javascript">

        $(document).ready(function() {
            var subject = '{{$examination->subject->slug}}';

            $(".subjects_list").select2({
                placeholder: "Select a subject",
                closeOnSelect: true,
            });

            $(".subjects_list").val(subject).trigger("change");


            $('.text_editor').summernote({
                minHeight:200
            });
        });
    </script>
@endpush
