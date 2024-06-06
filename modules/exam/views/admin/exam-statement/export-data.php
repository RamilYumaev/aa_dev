<?php
/* @var $model modules\exam\forms\ExamStatementMessageForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use kartik\select2\Select2;
use modules\exam\helpers\ExamHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-export']); ?>
<?= $form->field($model, 'date')->widget(DatePicker::class, [  'language' => 'ru',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
    ]]); ?>
<?= $form->field($model, 'discipline')->widget(Select2::class, [
    'options' => ['placeholder' => 'Выберите дисциплину',],
    'data' => ExamHelper::examList(),
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>
<?= $form->field($model, 'isProctor')->checkbox(); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>