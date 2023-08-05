<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones\model\CompetitiveGroupOnes */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-header">
        <h3><?= $this->title ?></h3>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'education_level')->textInput() ?>
                <?= $form->field($model, 'education_form')->textInput() ?>
                <?= $form->field($model, 'department')->textInput() ?>
                <?= $form->field($model, 'speciality')->textInput() ?>
                <?= $form->field($model, 'profile')->textInput() ?>
                <?= $form->field($model, 'type_competitive')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'kcp_transfer')->textInput() ?>
                <?= $form->field($model, 'kcp')->textInput() ?>
                <?= $form->field($model, 'file_name')->widget(FileInput::class, ['language'=> 'ru',
                    'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
                ]);?>
                <?= $form->field($model, 'check')->checkbox() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
