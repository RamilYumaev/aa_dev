<?php
/* @var $model modules\management\forms\DateFeastForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\color\ColorInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-task']); ?>
        <?= $form->field($model, 'date')->widget(\kartik\date\DatePicker::class, [
            'language' => 'ru',
            'pluginOptions' => [
                'startDate' => '+0d',
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
