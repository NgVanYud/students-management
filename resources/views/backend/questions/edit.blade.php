@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.questions.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@push('before-styles')
    {!! style(asset('plugins/select2/css/select2.min.css')) !!}
    {!! style(asset('plugins/summernote/summernote-bs4.css')) !!}
@endpush

@section('content')
    {{ html()->modelForm($question, 'PATCH', route('admin.chapter.question.update', [$chapter, $question]))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.questions.management') }}
                        <small class="text-muted">{{ __('labels.backend.questions.edit') }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4">
                <div class="col">

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.questions.chapters'))
                            ->class('col-md-2 form-control-label')
                            ->for('chapters') }}

                        <div class="col-md-10">
                            {{ html()->select('chapters', [null => null])
                                ->options($subjects_info)
                                ->class('form-control')
                                ->id('chapters_list')
                                ->value($chapter->slug)
                                ->required()}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div></div>

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.questions.content'))
                        ->class('col-md-2 form-control-label')->for('content') }}

                        <div class="col-md-10">
                            {{ html()->textarea('content')
                                ->class('form-control text_editor')}}
                        </div><!--col-->
                    </div><!--form-group-->
                    @php $correct_options_index = array(); @endphp
                    @foreach($question->answers as $option)
                        @if($option->is_correct)
                            @php $correct_options_index[] = ($loop->index); @endphp
                        @endif

                        <div class="form-group row">
                            <label class="col-md-2 form-control-label">Option #{{$loop->index +1}}</label>

                            <div class="col-md-10">
                                <textarea class="form-control text_editor" name="options[]">{!! $option->content !!}</textarea>
                            </div><!--col-->
                        </div><!--form-group-->
                    @endforeach

                    @if(config('question.multiple_choices'))
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.questions.correct_options'))
                            ->class('col-md-2 form-control-label')
                            ->for('correct_options') }}

                            <div class="col-md-10">
                                {{ html()->select('correct_options[]')
                                    ->multiple('multiple')
                                    ->options(create_question_options(config('question.options_num')))
                                    ->class('form-control')
                                    ->id('correct_options')
                                    ->required()}}
                            </div><!--col-->
                        </div><!--form-group-->
                    @else
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.questions.correct_options'))
                            ->class('col-md-2 form-control-label')
                            ->for('correct_options') }}

                            <div class="col-md-10">
                                {{ html()->select('correct_options', [null => null])
                                    ->options(create_question_options(config('question.options_num')))
                                    ->value(old('correct_options'))
                                    ->class('form-control')
                                    ->id('correct_options')
                                    ->required()}}
                            </div><!--col-->
                        </div><!--form-group-->
                    @endif


                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.access.users.active'))->class('col-md-2 form-control-label')->for('active') }}

                        <div class="col-md-10">
                            <label class="switch switch-3d switch-primary">
                                {{ html()->checkbox('is_actived', true, '1')->class('switch-input') }}
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div><!--col-->
                    </div><!--form-group-->

                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.chapter.question.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
    {!! script(asset('plugins/select2/js/select2.min.js')) !!}
    {!! script(asset('plugins/summernote/summernote-bs4.min.js')) !!}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#correct_options').select2({
                placeholder: "Select correct options",
            }).val({{json_encode($correct_options_index)}}).trigger("change");;

            $('#chapters_list').select2({
                placeholder: "Select a chapter",
            });

            $('.text_editor').summernote({
                minHeight:200
            });
        });
    </script>
@endpush
