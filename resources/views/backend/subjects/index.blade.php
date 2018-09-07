@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.subjects.all'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.subjects.management') }} <small class="text-muted">{{ __('labels.backend.subjects.all') }}</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.subjects.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('labels.backend.subjects.table.abbreviation') }}</th>
                                <th>{{ __('labels.backend.subjects.table.name') }}</th>
                                <th>{{ __('labels.backend.subjects.table.actived') }}</th>
                                <th>{{ __('labels.backend.subjects.table.credit') }}</th>
                                {{--<th>{{ __('labels.backend.subjects.users.table.confirmed') }}</th>--}}
                                <th>{{ __('labels.backend.access.users.table.last_updated') }}</th>
                                <th>{{ __('labels.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->abbreviation }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{!! $subject->actived_label !!}</td>
                                    <td>{{ $subject->credit }}</td>
{{--                                    <td>{!! $subject->confirmed_label !!}</td>--}}
                                    <td>{{ $subject->updated_at->diffForHumans() }}</td>
                                    <td>{!! $subject->action_buttons !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {!! $subjects->total() !!} {{ trans_choice('labels.backend.subjects.table.total', $subjects->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $subjects->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
