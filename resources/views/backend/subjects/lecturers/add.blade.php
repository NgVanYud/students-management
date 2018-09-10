@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.subjects.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.subject.lecturer.store', $subject))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.lecturers.management') }}
                        <small class="text-muted">{{ __('labels.backend.lecturers.add') }}</small>
                    </h4>
                    <h5 class="mt-2">
                        <a class="text-muted" href="{{route('admin.subject.show', $subject)}}" alt="">{{$subject->name}}</a>
                    </h5>
                </div><!--col-->
            </div><!--row-->


            <div class="row mt-4">
                <div class="col">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('labels.backend.access.users.table.select') }}</th>
                                <th>{{ __('labels.backend.access.users.table.last_name') }}</th>
                                <th>{{ __('labels.backend.access.users.table.first_name') }}</th>
                                <th>{{ __('labels.backend.access.users.table.username') }}</th>
                                <th>{{ __('labels.backend.access.users.table.roles') }}</th>
                                <th>{{ __('labels.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($lecturers as $lecturer)
                                <tr>
                                    <td>
                                        <label class="switch switch-3d switch-primary">
                                            {{ html()->checkbox('selected_lecturers[]', false, $lecturer->uuid)->class('switch-input') }}
                                            <span class="switch-label"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td>{{ $lecturer->last_name }}</td>
                                    <td>{{ $lecturer->first_name }}</td>
                                    <td>{{ $lecturer->username }}</td>
                                    <td>{!! $lecturer->roles_label !!}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            {!! $lecturer->show_button !!}
                                        </div>
                                    </td>
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
            </div><!--row-->

        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.subject.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.add')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection
