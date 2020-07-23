<?php
/* @var $model modules\exam\forms\ExamDateReserveForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
<?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingStartWidget()); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>