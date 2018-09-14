@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.subjects.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@push('before-styles')
    {!! style(asset('plugins/select2/css/select2.min.css')) !!}

@endpush

@section('content')

    {{ html()->form()->class('form-horizontal')->open() }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.questions.management') }}
                        <small class="text-muted">{{ __('labels.backend.questions.list') }}</small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.questions.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->

            <hr />
            <div class="row mt-4">
                <div class="col">

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.questions.chapters'))
                            ->class('col-1 form-control-label')
                            ->for('chapter') }}

                        <div class="col-7">
                            {{ html()->select('chapter', [null => null])
                                ->options($subjects_info)
                                ->class('form-control')
                                ->id('chapters_list')}}
                        </div><!--col-->

                        {{ html()->label(__('validation.attributes.backend.questions.status'))
                            ->class('col-1 form-control-label')
                            ->for('status') }}

                        <div class="col-3">
                            {{ html()->select('status', [null => null])
                                ->options([QuestionModel::ACTIVE_CODE => 'Actived', QuestionModel::INACTIVE_CODE => 'Deactived'])
                                ->class('form-control')
                                ->id('statuses_list')}}
                        </div><!--col-->

                    </div><!--form-group-->

                    <div class="questions_list">
                        @include('backend.questions.includes.load-list')
                    </div><!--questions_list-->

                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
    {{--{{ html()->form()->close() }}--}}
@endsection

@push('after-scripts')
    {!! script(asset('plugins/select2/js/select2.min.js')) !!}
    <script type="text/javascript">

        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getQuestions(page);
                }
            }
        });
        var chapter_slug, status_code;

        $(document).ready(function() {

            $("#chapters_list").select2({
                placeholder: "Select a chapter",
                closeOnSelect: true
            });

            $("#statuses_list").select2({
               placeholder: "Select a status",
               closeOnSelect: true
            });


             $("select[name='chapter'], select[name='status']").change(function() {
                 setBusyStatus();
                 chapter_slug = $("select[name='chapter']").val();
                 status_code = $("select[name='status']").val();

                 var token = $("input[name='_token']").val();
                 var url_process = '{{ route("admin.chapter.question.index") }}';
                 // url_process = url_process.replace(":slug", chapter_slug);
                 $.ajax({
                     url: url_process,
                     method: 'GET',
                     data: {
                         _token:token,
                         chapter_slug: chapter_slug,
                         status_code: status_code
                     },
                     dataType: 'json',

                     success: function(data) {
                         $(".questions_list").html(data);
                         resetBusyStatus();
                     },

                     error: function(error) {
                         alert('Can not get question in this chapter');
                         resetBusyStatus();
                     }
                 });
             });


            $(document).on('click', '.pagination a', function (e) {
                setBusyStatus();
                getQuestions($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
        });

        function getQuestions(page) {
            var data_post = {}
            // if(chapter_slug) {
                data_post = {
                    chapter_slug: chapter_slug,
                    status_code: status_code
                }
            // }
            $.ajax({
                url : '?page=' + page,
                dataType: 'json',
                data: data_post
            }).done(function (data) {
                $('.questions_list').html(data);
                location.hash = page;
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth'
                });
               resetBusyStatus();
            }).fail(function () {
                alert('Questions could not be loaded.');
            });
        }

        function resetBusyStatus() {
            $("#content-wrapper").css({"opacity": "1"});
            $(".loader").addClass('d-none');
        }

        function setBusyStatus() {
            $("#content-wrapper").css({"opacity": "0.2"});
            $(".loader").removeClass('d-none');
        }
    </script>
@endpush
