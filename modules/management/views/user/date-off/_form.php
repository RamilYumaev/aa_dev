<?php
/* @var $model modules\management\forms\DateOffForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use modules\management\models\PostRateDepartment;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-date-off']); ?>
        <?= $form->field($model, 'date')->widget(\kartik\date\DatePicker::class, [
            'language' => 'ru',
            'pluginOptions' => [
                'startDate' => '+0d',
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]]) ?>
        <?= $form->field($model, 'note')->textarea() ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

