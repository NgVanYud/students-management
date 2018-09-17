{{ html()->modelForm($examination, 'post', route('admin.examination.general_info.update', $examination))->class('form-horizontal')->open() }}
    <div class="form-group row">
        {{ html()->label(__('validation.attributes.backend.examinations.name'))
            ->class('col-md-2 form-control-label')
            ->for('name') }}

        <div class="col-md-10">
            {{ html()->text('name')
                ->class('form-control')
                ->placeholder(__('validation.attributes.backend.examinations.name'))
                ->attribute('maxlength', 191)
                ->required()}}
        </div><!--col-->
    </div><!--form-group-->

    <div class="form-group row">
        {{ html()->label(__('validation.attributes.backend.examinations.code'))
            ->class('col-md-2 form-control-label')
            ->for('code') }}

        <div class="col-md-10">
            {{ html()->text('code')
                ->class('form-control')
                ->placeholder(__('validation.attributes.backend.examinations.code'))
                ->attribute('maxlength', 191)
                ->required() }}
        </div><!--col-->
    </div><!--form-group-->

    <div class="form-group row">
        {{ html()->label(__('validation.attributes.backend.examinations.subject'))
            ->class('col-md-2 form-control-label')
            ->for('subject') }}

        <div class="col-md-10">
            {{ html()->select('subject', [null => null])
                ->options($subjects)
                ->class('form-control subjects_list')
                ->required()}}
        </div><!--col-->
    </div><!--form-group-->

    <div class="form-group row">
        {{ html()->label(__('validation.attributes.backend.examinations.begin_time'))
            ->class('col-md-2 form-control-label')
            ->for('begin_time') }}

        <div class="col-md-5">
            {{ html()->date('begin_date')
                ->class('form-control')
                ->value($examination->begin_time->toDateString())
                ->required()}}

        </div><!--col-->
        <div class="col-md-5">
            {{ html()->time('begin_time')
                ->class('form-control')
                ->value($examination->begin_time->toTimeString())
                ->required()}}
        </div><!--col-->
    </div><!--form-group-->

    <div class="form-group row">
        {{ html()->label(__('validation.attributes.backend.subjects.active'))->class('col-md-2 form-control-label')->for('is_actived') }}

        <div class="col-md-10">
            <label class="switch switch-3d switch-primary">
                {{ html()->checkbox('is_actived')->class('switch-input')->attributeIf(old('is_actived', $examination->is_actived == ExaminationModel::ACTIVE_CODE), 'checked', 'checked') }}
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
            </label>
        </div><!--col-->
    </div><!--form-group-->

    <div class="form-group row">
        {{ html()->label(__('validation.attributes.backend.examinations.note'))
        ->class('col-md-2 form-control-label')->for('note') }}

        <div class="col-md-10">
            {{ html()->textarea('note')
                ->class('form-control text_editor')}}
        </div><!--col-->
    </div><!--form-group-->

    <div class="row">
        <div class="col">
            {{ form_cancel(route('admin.examination.index'), __('buttons.general.cancel')) }}
        </div><!--col-->

        <div class="col text-right">
            {{ form_submit(__('buttons.general.crud.update')) }}
        </div><!--col-->
    </div><!--row-->
{{ html()->form()->close() }}
