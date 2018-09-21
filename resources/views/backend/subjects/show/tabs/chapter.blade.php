<div class="col">
    @php $chapters = $subject->chaptersWithPaginate(); @endphp
    @if($logged_in_user->isValidQuizMaker($subject))
        @include('backend.subjects.includes.chapter-header-buttons', ['subject' => $subject])
    @endif
    <div class="table-responsive">

        <table class="table table-hover mt-3">
            <thead>
            <tr>
                <th>{{ __('labels.backend.subjects.chapters.table.name') }}</th>
                @if($logged_in_user->isValidQuizMaker($subject))
                    <th>{{ __('labels.backend.subjects.chapters.table.actived') }}</th>
                @endif
                <th>{{ __('labels.backend.subjects.chapters.table.question_num') }}</th>
                <th>{{ __('labels.backend.access.users.table.last_updated') }}</th>

                @if($logged_in_user->isValidQuizMaker($subject))
                    <th>{{ __('labels.general.actions') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($chapters as $chapter)
                <tr>
                    <td>{{ $chapter->name }}</td>
                    @if($logged_in_user->isValidQuizMaker($subject))
                        <td>{!! $chapter->actived_label !!}</td>
                    @endif
                    <td>{{ count($chapter->questions) }}</td>
                    <td>{!! $chapter->updated_at->diffForHumans() !!}</td>
                    @if($logged_in_user->isValidQuizMaker($subject))
                        <td>{!! $chapter->action_buttons !!}</td>
                    @endif
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