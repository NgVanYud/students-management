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
                        {{ __('labels.backend.examinations.management') }}
                        <small class="text-muted">{{ __('labels.backend.examinations.tests.list') }}</small>
                    </h4>
                    <h5 class="mt-2">
                        {{$examination->name}}
                    </h5>
                </div><!--col-->

                {{--<div class="col-sm-7">--}}
                    {{--@include('backend.questions.includes.header-buttons')--}}
                {{--</div><!--col-->--}}
            </div><!--row-->

            <hr />
            <div class="row mt-4">
                <div class="col">

                    <div class="form-group row">
                        {{ html()->label('Tests')
                            ->class('col-1 form-control-label')
                            ->for('test') }}

                        <div class="col-7">
                            {{ html()->select('test', [null => null])
                                ->options($tests_info)
                                ->class('form-control')
                                ->id('tests_list')}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="tests_list">
                        @include('backend.examinations.tests.includes.questions-list')
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
        var test_uuid;

        $(document).ready(function() {

            $("#tests_list").select2({
                placeholder: "Select a test",
                closeOnSelect: true
            });

            $("select[name='test']").change(function() {
                setBusyStatus();
                test_uuid = $("select[name='test']").val();

                var token = $("input[name='_token']").val();
                var exam_uuid = '{{$examination->uuid}}';
                var url_process = '{{ route("admin.examination.show", ":uuid") }}';
                url_process = url_process.replace(":uuid", exam_uuid);
                $.ajax({
                    url: url_process,
                    method: 'GET',
                    data: {
                        _token:token,
                        test_uuid: test_uuid,
                    },
                    dataType: 'json',

                    success: function(data) {
                        $(".tests_list").html(data);
                        resetBusyStatus();
                    },

                    error: function(error) {
                        alert('Can not get question in this test');
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
                test_uuid: test_uuid,
            }
            // }
            $.ajax({
                url : '?page=' + page,
                dataType: 'json',
                data: data_post
            }).done(function (data) {
                $('.tests_list').html(data);
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
