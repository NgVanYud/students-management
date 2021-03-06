<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                {{ __('menus.backend.sidebar.general') }}
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}"><i class="icon-speedometer"></i> {{ __('menus.backend.sidebar.dashboard') }}</a>
            </li>

            <li class="nav-title">
                {{ __('menus.backend.sidebar.system') }}
            </li>

            {{--Giao vien--}}
            {{--<li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/subjects*'), 'open') }}">--}}
                {{--<a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="#">--}}
                    {{--<i class="icon-user"></i> {{ __('menus.backend.lecturers.title') }}--}}
                {{--</a>--}}

                {{--<ul class="nav-dropdown-items">--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="{{ route('admin.lecturer.total') }}">--}}
                            {{--{{ __('labels.backend.lecturers.modify') }}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="{{ route('admin.subject.index') }}">--}}
                            {{--{{ __('labels.backend.lecturers.all') }}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects/create*')) }}" href="{{ route('admin.subject.create') }}">--}}
                            {{--{{ __('labels.backend.lecturers.add') }}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}

            @if($logged_in_user->isTeacher() && !$logged_in_user->isCurator() && !$logged_in_user->isProctor() || $logged_in_user->isAdmin())
            {{--Môn học--}}
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/subjects*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="#">
                        <i class="icon-user"></i> {{ __('menus.backend.subjects.title') }}
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="{{ route('admin.subject.index') }}">
                                {{ __('labels.backend.subjects.all') }}
                            </a>
                        </li>
                        @if($logged_in_user->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects/create*')) }}" href="{{ route('admin.subject.create') }}">
                                    {{ __('labels.backend.subjects.create') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects/deleted*')) }}" href="{{ route('admin.subject.deleted') }}">
                                    {{ __('labels.backend.subjects.deleted') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($logged_in_user->isQuizMaker())
            {{--Questions--}}
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/subjects*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="#">
                        <i class="icon-user"></i> {{ __('menus.backend.questions.title') }}
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="{{ route('admin.chapter.question.index') }}">
                                {{ __('labels.backend.questions.all') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects/create*')) }}" href="{{route('admin.chapter.question.create')}}">
                                {{ __('labels.backend.questions.create') }}
                            </a>
                        </li>
                        {{--<li class="nav-item">--}}
                            {{--<a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects/deleted*')) }}" href="{{route('admin.question.deleted')}}">--}}
                                {{--{{ __('labels.backend.questions.deleted') }}--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>
            @endif

            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                    <i class="icon-user"></i> {{ __('menus.backend.examinations.title') }}
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects*')) }}" href="{{ route('admin.examination.index') }}">
                            {{ __('labels.backend.examinations.all') }}
                        </a>
                    </li>
                    @if($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects/create*')) }}" href="{{route('admin.examination.create')}}">
                            {{ __('labels.backend.examinations.create') }}
                        </a>
                    </li>
                    @endif
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link {{ active_class(Active::checkUriPattern('admin/subjects/deleted*')) }}" href="">--}}
                            {{--{{ __('labels.backend.examinations.deleted') }}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ul>
            </li>

            {{--Access--}}
            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                        <i class="icon-user"></i> {{ __('menus.backend.access.title') }}

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger float-none">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                {{ __('labels.backend.access.users.management') }}

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                {{ __('labels.backend.access.roles.management') }}
                            </a>
                        </li>
                    </ul>
                </li>

            @endif

            @if($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}" href="#">
                        <i class="icon-list"></i> {{ __('menus.backend.log-viewer.main') }}
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                                {{ __('menus.backend.log-viewer.dashboard') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                                {{ __('menus.backend.log-viewer.logs') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>
    </nav>
</div><!--sidebar-->