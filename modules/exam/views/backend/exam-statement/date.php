<?php
/* @var $model modules\exam\forms\ExamDateReserveForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use modules\exam\helpers\ExamHelper;
use modules\exam\helpers\ExamStatementHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
<?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingStartWidget()); ?>
<?php if ($model->scenario == \modules\exam\forms\ExamDateReserveForm::PUBLIC_TRANSFER) : ?>
<?= $form->field($model, 'exam_id')->dropDownList(ExamHelper::examList()); ?>
<?= $form->field($model, 'time')->dropDownList(ExamStatementHelper::timeList()); ?>
<?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>