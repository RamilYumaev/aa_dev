<?php
/* @var $model modules\exam\forms\ExamStatementProctorForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use modules\entrant\helpers\DateFormatHelper;
use modules\exam\helpers\ExamStatementHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$times = ExamStatementHelper::timeList();
if ($model->voz) {
    unset($times['14:00']);
}
?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
<?= $form->field($model, 'proctor_user_id')->widget(Select2::class, [
    'data'=> ExamStatementHelper::proctorList(),
    'options'=> ['placeholder'=>'Выберите проктора'],
    'pluginOptions' => ['allowClear' => true],
]) ?>
<?= $form->field($model, 'time')->dropDownList($times); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>