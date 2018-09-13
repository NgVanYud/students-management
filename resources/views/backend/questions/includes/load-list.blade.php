<div class="table-responsive table-striped">
    <table class="table">
        <thead>
        <tr>
            <th>{{ __('labels.backend.questions.table.contents') }}</th>
            <th>{{ __('labels.backend.questions.table.actived') }}</th>
            <th>{{ __('labels.general.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($questions as $question)
            @php $count = (($questions->currentPage() - 1 ) * $questions->perPage() ) + $loop->iteration; @endphp
            <tr>
                <td>
                    <div class="form-group">
                        <strong>Question {{$count}}. {!! nl2br($question->content) !!}</strong>
                        <ul>
                            @foreach($question->answers as $option)
                                <li class="{{$option->is_correct ? 'text-primary' : ''}}">
                                    {!! $option->content !!}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </td>
                <td>{!! $question->actived_label !!}</td>
                <td>{!! $question->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

    <div class="row">
        <div class="col-7">
            <div class="float-left">
                {!! $questions->total() !!} {{ trans_choice('labels.backend.questions.table.total', $questions->total()) }}
            </div>
        </div><!--col-->

        <div class="col-5">
            <div class="float-right">
                {!! $questions->render() !!}
            </div>
        </div><!--col-->
    </div><!--row-->
