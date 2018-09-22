<div class="col">

    <div class="table-responsive">
        <table class="table table-hover">

            <tr>
                <th>{{ __('labels.backend.subjects.tabs.content.subject.name') }}</th>
                <td>{{ $subject->name }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.subjects.tabs.content.subject.abbreviation') }}</th>
                <td>{{ $subject->abbreviation }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.subjects.tabs.content.subject.credit') }}</th>
                <td>{{ $subject->credit }}</td>
            </tr>

            @if($logged_in_user->isAdmin())
                <tr>
                    <th>{{ __('labels.backend.subjects.tabs.content.subject.actived') }}</th>
                    <td>{!! $subject->actived_label !!}</td>
                </tr>
            @endif

            {{--<tr>--}}
                {{--<th>{{ __('labels.backend.subjects.tabs.content.subject.status') }}</th>--}}
                {{--<td>{!! $subject->status_label !!}</td>--}}
            {{--</tr>--}}
            <tr>
                <th>{{ __('labels.backend.subjects.tabs.content.subject.lecturers_num') }}</th>
                <td>{{ count($subject->lecturers) }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.subjects.tabs.content.subject.chapters_num') }}</th>
                <td>{{ count($subject->chapters) }}</td>
            </tr>

            <tr>
                <th>{{ __('labels.backend.subjects.tabs.content.subject.questions_num') }}</th>
                <td>{{ count($subject->questions) }}</td>
            </tr>

        </table>
    </div>
</div><!--table-responsive-->