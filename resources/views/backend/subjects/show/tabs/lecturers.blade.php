<div class="col">
    @php $lecturers = $subject->lecturersWithPaginate(); @endphp
    @include('backend.subjects.includes.lecturer-header-buttons', ['subject' => $subject])
    <div class="table-responsive">

        <table class="table table-hover mt-3">
            <thead>
            <tr>
                <th>{{ __('labels.backend.subjects.lecturers.table.last_name') }}</th>
                <th>{{ __('labels.backend.subjects.lecturers.table.first_name') }}</th>
                <th>{{ __('labels.backend.subjects.lecturers.table.username') }}</th>
                <th>{{ __('labels.backend.subjects.lecturers.table.role') }}</th>
                <th>{{ __('labels.general.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lecturers as $lecturer)
                <tr>
                    <td>{{ $lecturer->last_name }}</td>
                    <td>{!! $lecturer->first_name !!}</td>
                    <td>{!! $lecturer->username !!}</td>
                    <td>{!! $lecturer->permissions_label !!}</td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group" aria-label="User Actions">
                            {!! $lecturer->show_button !!}
                            {!! $lecturer->edit_button !!}
                            <div class="btn-group btn-group-sm" role="group">
                                <button id="lecturerActions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    More
                                </button>
                                <div class="dropdown-menu" aria-labelledby="lecturerActions">
                                    {!! $lecturer->delete_button !!}
                                </div>
                            </div>
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
                {!! $lecturers->total() !!} {{ trans_choice('labels.backend.subjects.lecturers.table.total', $lecturers->total()) }}
            </div>
        </div><!--col-->

        <div class="col-5">
            <div class="float-right">
                {!! $lecturers->render() !!}
            </div>
        </div><!--col-->
    </div><!--row-->
</div><!--table-responsive-->