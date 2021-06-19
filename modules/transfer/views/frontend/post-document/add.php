<?php
/* @var  $this \yii\web\View  */
/* @var $model modules\transfer\forms\PacketDocumentUserForm
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="mt-20 table-responsive">
    <?php $form = ActiveForm::begin(['id'=> 'form-transfer']); ?>
    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
    <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
    <?php if($model->isRemove()): ?>
        <?= $form->field($model, 'note')->textInput(['maxlength' => true])->label('Причина отчисления') ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
