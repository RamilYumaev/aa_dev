<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model modules\literature\models\LiteratureOlympic */

use kartik\date\DatePicker;
use kartik\file\FileInput;
use modules\entrant\helpers\DateFormatHelper; ?>
<fieldset>
    <legend>Паспортные данные участника</legend>
    <div class="col-md-4">
        <?= $form->field($model, 'type')->dropDownList($model->getDocuments()) ?>
        <?= $form->field($model, 'birthday')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
        <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'date_issue')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
        <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'region')->dropDownList(\dictionary\helpers\DictRegionHelper::regionList()) ?>
        <?= $form->field($model, 'zone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'photo')->widget(FileInput::class, ['language'=> 'ru',
            'options' => ['accept' => 'image/*'],
        ]);?>
    </div>
</fieldset>
<fieldset>
    <legend>Образовательная организация участника</legend>
    <div class="col-md-6">
        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>
    </div>
</fieldset>
<fieldset>
    <div class="col-md-6">
        <?= $form->field($model, 'status_olympic')->dropDownList($model->getOlympicStatuses()) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'mark_olympic')->textInput(['maxlength' => true]) ?>
    </div>
</fieldset>
<fieldset>
    <div class="col-md-6">
        <?= $form->field($model, 'grade_number')->dropDownList($model->getGrades()) ?>
    </div>
<!--    <div class="col-md-4">-->
<!--        --><?php // $form->field($model, 'grade_letter')->textInput(['maxlength' => true]) ?>
<!--    </div>-->
    <div class="col-md-6">
        <?= $form->field($model, 'grade_performs')->dropDownList($model->getGrades()) ?>
    </div>
</fieldset>
<fieldset>
    <div class="col-md-6">
       <?= $form->field($model, 'fio_teacher')->textInput(['maxlength' => true]) ?>
       <?= $form->field($model, 'place_work')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'academic_degree')->textInput(['maxlength' => true]) ?>
    </div>
</fieldset>
<fieldset>
    <legend>Прочие данныне участника</legend>
        <?= $form->field($model, 'size')->dropDownList($model->getSizes())?>
    <div class="col-md-4">
        <?= $form->field($model, 'is_allergy')->checkbox()?>
        <?= $form->field($model, 'note_allergy')->textarea()?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'is_need_conditions')->checkbox()?>
        <?= $form->field($model, 'note_conditions')->textarea() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'is_voz')->checkbox()?>
        <?= $form->field($model, 'note_special')->textarea() ?>
    </div>
</fieldset>
<fieldset>
    <legend>Маршрут</legend>
    <div class="col-md-6">
        <?= $form->field($model, 'date_arrival')->widget(\kartik\datetime\DateTimePicker::class,
            ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii:00'
            ]]); ?>
        <?= $form->field($model, 'type_transport_arrival')->dropDownList($model->getTransports()) ?>
        <?= $form->field($model, 'place_arrival')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'number_arrival')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'date_departure')->widget(\kartik\datetime\DateTimePicker::class,
            ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii:00'
            ]]); ?>
        <?= $form->field($model, 'type_transport_departure')->dropDownList($model->getTransports()) ?>
        <?= $form->field($model, 'place_departure')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'number_departure')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'agree_file')->widget(FileInput::class, ['language'=> 'ru',
        'options' => ['accept' => 'image/*'],
    ]);?>
</fieldset>








