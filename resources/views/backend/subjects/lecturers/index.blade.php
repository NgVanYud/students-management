@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.subjects.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@push('before-styles')
    {!! style(asset('plugins/select2/css/select2.min.css')) !!}
@endpush

@section('content')
    {{ html()->form('GET', route('admin.subject.index'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.lecturers.management') }}
                        <small class="text-muted">{{ __('labels.backend.lecturers.modify') }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.lecturers.subjects'))
                            ->class('col-md-2 form-control-label')
                            ->for('subjects') }}

                        <div class="col-md-10">
                            {{ html()->select('subjects', [null => null] + $subjects->toArray())
                                ->class('form-control')
                                ->id('subjects_list')}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.lecturers.lecturers'))
                            ->class('col-md-2 form-control-label')
                            ->for('subjects') }}

                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('labels.backend.access.users.table.last_name') }}</th>
                                        <th>{{ __('labels.backend.access.users.table.first_name') }}</th>
                                        <th>{{ __('labels.backend.access.users.table.username') }}</th>
                                        <th>{{ __('labels.backend.access.users.table.roles') }}</th>
                                        <th>{{ __('labels.backend.access.users.table.other_permissions') }}</th>
                                        <th>{{ __('labels.general.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($lecturers as $lecturer)
                                        <tr>
                                            <td>{{ $lecturer->last_name }}</td>
                                            <td>{{ $lecturer->first_name }}</td>
                                            <td>{{ $lecturer->username }}</td>
                                            <td>{!! $lecturer->roles_label !!}</td>
                                            <td>{!! $lecturer->permissions_label !!}</td>
                                            <td>{!! $lecturer->action_buttons !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-7">
                                    <div class="float-left">
                                        {!! $lecturers->total() !!} {{ trans_choice('labels.backend.lecturers.table.total', $lecturers->total()) }}
                                    </div>
                                </div><!--col-->

                                <div class="col-5">
                                    <div class="float-right">
                                        {!! $lecturers->render() !!}
                                    </div>
                                </div><!--col-->
                            </div><!--row-->

                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->

        {{--<div class="card-footer">--}}
            {{--<div class="row">--}}
                {{--<div class="col">--}}
                    {{--{{ form_cancel(route('admin.subject.show', [$subject, SubjectModel::TAB_TYPES['chapters']]), __('buttons.general.cancel')) }}--}}
                {{--</div><!--col-->--}}

                {{--<div class="col text-right">--}}
                    {{--{{ form_submit(__('buttons.general.crud.update')) }}--}}
                {{--</div><!--col-->--}}
            {{--</div><!--row-->--}}
        {{--</div><!--card-footer-->--}}
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
    {!! script(asset('plugins/select2/js/select2.min.js')) !!}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#subjects_list").select2({
                placeholder: "Select a subject",
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
