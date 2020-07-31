<?php
/* @var $model modules\exam\forms\ExamDateReserveForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use modules\entrant\helpers\DateFormatHelper;
use modules\exam\helpers\ExamStatementHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['id'=> 'form-message']); ?>
<?= $form->field($model, 'proctor_user_id')->widget(Select2::class, [
    'data'=> ExamStatementHelper::proctorList(),
    'options'=> ['placeholder'=>'Выберите проктора'],
    'pluginOptions' => ['allowClear' => true],
]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>