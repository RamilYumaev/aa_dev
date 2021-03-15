<?php
/* @var $model modules\management\forms\CategoryDocumentForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\color\ColorInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-category']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
