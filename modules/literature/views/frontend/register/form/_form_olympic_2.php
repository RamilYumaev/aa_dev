<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model modules\literature\models\LiteratureOlympic */

use kartik\date\DatePicker;
use kartik\file\FileInput;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
<div class="row">
<div class="col-md-5">
    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_olympic')->dropDownList($model->getOlympicStatuses()) ?>

    <?= $form->field($model, 'mark_olympic')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'grade_number')->dropDownList($model->getGrades()) ?>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-4">
            <?=  $form->field($model, 'grade_letter')->dropDownList($model->getLetters())->label('Литер') ?>
        </div>
    </div>
    <?= $form->field($model, 'grade_performs')->dropDownList($model->getGrades()) ?>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">

        <?= $form->field($model, 'fio_teacher')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'place_work')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'academic_degree')->dropDownList($model->getAcademicDegreeList()) ?>
        </div>
</div>
<div class="col-md-12 mb-20">
    <div class="form-group">
        <?= Html::submitButton('Далее', ['class' => 'btn btn-success btn-lg pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>