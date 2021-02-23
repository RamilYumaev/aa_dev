<?php
/* @var $model modules\management\forms\DictTaskForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\color\ColorInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-task']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'color')->widget(ColorInput::classname(), [
            'options' => ['placeholder' => 'Выберите цвет'],
        ]);?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
