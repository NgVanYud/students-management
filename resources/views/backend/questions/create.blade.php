@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.subjects.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@push('before-styles')
    {!! style(asset('plugins/select2/css/select2.min.css')) !!}
@endpush

@section('content')
    {{ html()->form('POST', route('admin.question.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.questions.management') }}
                        <small class="text-muted">{{ __('labels.backend.questions.create') }}</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.questions.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4">
                <div class="col">

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.questions.chapters'))
                            ->class('col-md-2 form-control-label')
                            ->for('chapters') }}

                        <div class="col-md-10">
                            {{ html()->select('chapters', [null => null])
                                ->options($subjects_info)
                                ->class('form-control')
                                ->id('chapters_list')}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.password'))->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-10">
                            {{ html()->text('content')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.access.users.password'))
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.active'))->class('col-md-2 form-control-label')->for('active') }}

                        <div class="col-md-10">
                            <label class="switch switch-3d switch-primary">
                                {{ html()->checkbox('active', true, '1')->class('switch-input') }}
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div><!--col-->
                    </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.question.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
    {!! script(asset('plugins/select2/js/select2.min.js')) !!}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#subjects_list, #chapters_list").select2({
                placeholder: "Select a subject",
            });

            $("#chapters_list").select2({
                placeholder: "Select a chapter",
            });

            $('#subjects_list').change(function() {
                var subject = $(this).val(); //get the current value's option
                $.ajax({
                    type:'GET',
                    {{--url:'{{route('')}}',--}}
                    data:{'id':id},
                    success:function(data){
                        //in here, for simplicity, you can substitue the HTML for a brand new select box for countries
                        //1.
                        $(".countries_container").html(data);

                        //2.
                        // iterate through objects and build HTML here
                    }
                });
            });
        });
    </script>
@endpush
