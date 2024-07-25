<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones_2024\model\CgSS */
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
                <?= $form->field($model, 'speciality')->textInput() ?>
                <?= $form->field($model, 'profile')->textInput() ?>
                <?= $form->field($model, 'type')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'kcp')->textInput() ?>
                <?= $form->field($model, 'url')->textarea() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
