<h5>List Proctors</h5>

<div class="col">

    <div class="table-responsive">

        <table class="table table-hover mt-3">
            <thead>
            <tr>
                <th>{{ __('labels.backend.access.users.table.name') }}</th>
                <th>{{ __('labels.backend.access.users.table.username') }}</th>
                <th>{{ __('labels.backend.access.users.table.birthday') }}</th>
                <th>{{ __('labels.backend.access.users.table.identity') }}</th>
                <th>{{ __('labels.backend.access.users.table.gender') }}</th>
                {{--<th>{{ __('labels.general.actions') }}</th>--}}
            </tr>
            </thead>
            <tbody>
            @php $proctors = $examination->proctors; @endphp
            @foreach($proctors as $proctor)
                <tr>
                    <td>{{ $proctor->fullname }}</td>
                    <td>{{ $proctor->username }}</td>
                    <td>{{ $proctor->birthday }}</td>
                    <td>{{ $proctor->identity }}</td>
                    <td>{{ $proctor->gender_string }}</td>
                    {{--<td>--}}
                    {{--<div class="btn-group btn-group-sm" role="group" aria-label="Examination Actions">--}}
                    {{--<a href="{{route('admin.auth.user.show', $proctor)}}"--}}
                    {{--data-toggle="tooltip" data-placement="top"--}}
                    {{--title="{{ __('buttons.general.crud.view') }}"--}}
                    {{--class="btn btn-info"><i class="fas fa-eye"></i></a>;--}}

                    {{--<a href="{{route('admin.examination.student.destroy', [$examination, $proctor])}}"--}}
                    {{--data-method="delete"--}}
                    {{--data-trans-button-cancel="{{ __('buttons.general.cancel') }}"--}}
                    {{--data-trans-button-confirm="{{ __('buttons.general.crud.delete') }}"--}}
                    {{--data-trans-title="{{__('strings.backend.general.are_you_sure') }}"--}}
                    {{--class="dropdown-item"><i class="fa fa-minus-square" aria-hidden="true"></i></a>;--}}

                    {{--</div>--}}
                    {{--</td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="row">
        <div class="col-7">
            <div class="float-left">
                {!! count($proctors) !!} {{ trans_choice('labels.backend.access.users.table.total', count($proctors)) }}
            </div>
        </div><!--col-->
    </div><!--row-->
</div><!--table-responsive-->

<hr>

<form class="form-horizontal" action="{{ route('admin.examination.proctor.update', $examination)}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
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

<div class="row">
    <div class="col">
        {{ form_cancel(route('admin.examination.index'), __('buttons.general.cancel')) }}
    </div><!--col-->

    <div class="col text-right">
        {{ form_submit(__('buttons.general.crud.update')) }}
    </div><!--col-->
</div><!--row-->
</form>
