@extends ('backend.layouts.app')

@section ('title', __('labels.backend.subjects.management') . ' | ' . __('labels.backend.subjects.view'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.subjects.management') }}
                        <small class="text-muted">{{ __('labels.backend.subjects.view') }}</small>
                    </h4>
                    <h5 class="mt-2">
                        <a class="text-muted" href="{{route('admin.subject.show', $subject)}}" alt="">{{$subject->name}}</a>
                    </h5>
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4 mb-4">
                <div class="col">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['subjects'])) ? 'active' : ''}}" data-toggle="tab" href="#subject" role="tab" aria-controls="subjects" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['subjects']))}}"><i class="fas fa-book"></i> {{ __('labels.backend.subjects.tabs.titles.subject') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['chapters'])) ? 'active' : ''}}" data-toggle="tab" href="#chapter" role="tab" aria-controls="chapters" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['chapters']))}}"><i class="fas fa-book"></i> {{ __('labels.backend.subjects.tabs.titles.chapters') }}</a>
                        </li>

                        @if($logged_in_user->isValidQuizMaker($subject))
                            <li class="nav-item">
                                <a class="nav-link {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['deleted_chapters'])) ? 'active' : ''}}" data-toggle="tab" href="#deteled_chapter" role="tab" aria-controls="deleted_chapters" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['deleted_chapters']))}}"><i class="fas fa-book"></i> {{ __('labels.backend.subjects.tabs.titles.deleted_chapters') }}</a>
                            </li>
                        @endif
                        @if($logged_in_user->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['lecturers'])) ? 'active' : ''}}" data-toggle="tab" href="#lecturer" role="tab" aria-controls="lecturers" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['lecturers']))}}"><i class="fas fa-book"></i> {{ __('labels.backend.subjects.tabs.titles.lecturers') }}</a>
                            </li>
                        @endif

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['subjects'])) ? 'active' : ''}}" id="subject" role="tabpanel" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['subjects']))}}">
                            @include('backend.subjects.show.tabs.subject')
                        </div><!--tab-->

                        <div class="tab-pane {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['chapters'])) ? 'active' : ''}}" id="chapter" role="tabpanel" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['chapters']))}}">
                            @include('backend.subjects.show.tabs.chapter')
                        </div><!--tab-->

                        @if($logged_in_user->isValidQuizMaker($subject))
                            <div class="tab-pane {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['deleted_chapters'])) ? 'active' : ''}}" id="deteled_chapter" role="tabpanel" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['deleted_chapters']))}}">
                                @include('backend.subjects.show.tabs.deleted-chapter')
                            </div><!--tab-->
                        @endif

                        @if($logged_in_user->isAdmin())
                            <div class="tab-pane {{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['lecturers'])) ? 'active' : ''}}" id="lecturer" role="tabpanel" aria-expanded="{{(isset($tab_type) && ($tab_type == SubjectModel::TAB_TYPES['lecturers']))}}">
                                @include('backend.subjects.show.tabs.lecturers')
                            </div><!--tab-->
                        @endif

                    </div><!--tab-content-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <small class="float-right text-muted">
                        <strong>{{ __('labels.backend.subjects.tabs.content.subject.created_at') }}:</strong> {{ timezone()->convertToLocal($subject->created_at) }} ({{ $subject->created_at->diffForHumans() }}),
                        <strong>{{ __('labels.backend.subjects.tabs.content.subject.last_updated') }}:</strong> {{ timezone()->convertToLocal($subject->updated_at) }} ({{ $subject->updated_at->diffForHumans() }})
                        @if ($subject->trashed())
                            <strong>{{ __('labels.backend.subjects.tabs.content.subject.deleted_at') }}:</strong> {{ timezone()->convertToLocal($subject->deleted_at) }} ({{ $subject->deleted_at->diffForHumans() }})
                        @endif
                    </small>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
@endsection
