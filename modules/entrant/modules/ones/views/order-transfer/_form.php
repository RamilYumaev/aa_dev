<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones\model\OrderTransferOnes */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-header">
        <h3><?= $this->title ?></h3>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'education_level')->widget(Select2::class, [
                    'data' => $model::allEduLevels(),
                    'options' => ['multiple' => true],
                ]) ?>
                <?= $form->field($model, 'department')->widget(Select2::class, [
                    'data' => $model::allDepartments(),
                ]) ?>
                <?= $form->field($model, 'type_competitive')->widget(Select2::class, [
                    'data' => $model::allTypes(),
                    'options' => ['multiple' => true],
                ]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
