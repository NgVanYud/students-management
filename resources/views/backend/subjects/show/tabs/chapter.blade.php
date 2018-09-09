<div class="col">
    @php $chapters = $subject->chapters(); @endphp
    @include('backend.subjects.includes.chapter-header-buttons', ['subject' => $subject])
    <div class="table-responsive">

        <table class="table table-hover mt-3">
            <thead>
            <tr>
                <th>{{ __('labels.backend.subjects.chapters.table.name') }}</th>
                <th>{{ __('labels.backend.subjects.chapters.table.actived') }}</th>
                <th>{{ __('labels.backend.subjects.chapters.table.question_num') }}</th>
                <th>{{ __('labels.backend.access.users.table.last_updated') }}</th>
                <th>{{ __('labels.general.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($chapters as $chapter)
                <tr>
                    <td>
                        <a class="text-dark" href="{{route('admin.subject.chapter.show', [$subject, $chapter])}}">{{ $chapter->name }}</a>
                    </td>
                    <td>{!! $chapter->actived_label !!}</td>
                    <td>{!! 0 !!}</td>
                    <td>{!! $chapter->updated_at->diffForHumans() !!}</td>
                    <td>{!! $chapter->action_buttons !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div class="row">
        <div class="col-7">
            <div class="float-left">
                {!! $chapters->total() !!} {{ trans_choice('labels.backend.subjects.chapters.table.total', $chapters->total()) }}
            </div>
        </div><!--col-->

        <div class="col-5">
            <div class="float-right">
                {!! $chapters->render() !!}
            </div>
        </div><!--col-->
    </div><!--row-->
</div><!--table-responsive-->