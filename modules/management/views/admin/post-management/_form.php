<?php
/* @var $model modules\management\forms\PostManagementForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\color\ColorInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-post-management']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name_short')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'is_director')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
