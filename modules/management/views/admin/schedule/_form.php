<?php
/* @var $model modules\management\forms\ScheduleForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-schedule']); ?>
        <?= $form->field($model, 'monday')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'tuesday')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'wednesday')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'thursday')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'friday')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'saturday')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'sunday')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
