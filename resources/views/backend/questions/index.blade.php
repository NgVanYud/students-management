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
                            ->class('col-12 form-control-label')
                            ->for('chapter') }}

                        <div class="col-12">
                            {{ html()->select('chapter', [null => null])
                                ->options($subjects_info)
                                ->class('form-control')
                                ->id('chapters_list')}}
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
        var chapter_slug;

        $(document).ready(function() {

            $("#chapters_list").select2({
                placeholder: "Select a chapter",
                closeOnSelect: true
            });


             $("select[name='chapter']").change(function() {
                 chapter_slug = $(this).val();
                 var token = $("input[name='_token']").val();
                 {{--$("body").css({--}}
                     {{--"position": "fix",--}}
                     {{--"top": "0px",--}}
                     {{--"left": "0px",--}}
                     {{--"width": "100%",--}}
                     {{--"height": "100%",--}}
                     {{--"z-index": "9999 !important",--}}
                    {{--"background": "url({{asset('img/backend/loading.gif')}}) 50% 50% no-repeat rgb(249,249,249)"--}}
                 {{--});--}}
                 var url_process = '{{ route("admin.chapter.question.index") }}';
                 // url_process = url_process.replace(":slug", chapter_slug);
                 $.ajax({
                     url: url_process,
                     method: 'GET',
                     data: {
                         _token:token,
                         chapter_slug: chapter_slug
                     },
                     dataType: 'json',

                     success: function(data) {
                         $(".questions_list").html(data);
                         console.log(data);
                     },

                     error: function(error) {
                         console.log(error);
                     }
                 });
             });


            $(document).on('click', '.pagination a', function (e) {
                getQuestions($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
        });

        function getQuestions(page) {
            var data_post = {}
            if(chapter_slug) {
                data_post = {
                    chapter_slug: chapter_slug
                }
            }
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
            }).fail(function () {
                alert('Questions could not be loaded.');
            });
        }
    </script>
@endpush
