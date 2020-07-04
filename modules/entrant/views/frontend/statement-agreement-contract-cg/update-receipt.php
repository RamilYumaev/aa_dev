<?php

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var  $type integer|null */
/* @var $model modules\entrant\forms\ReceiptContractForm */
?>
<?php $form = ActiveForm::begin(['id' => 'form-receipt']); ?>
<?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'pay_sum')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>