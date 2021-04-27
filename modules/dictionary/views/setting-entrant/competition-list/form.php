<?php
/* @var $model modules\dictionary\forms\SettingCompetitionListForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var  $modelSettingEntrant modules\dictionary\models\SettingEntrant */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = "Настройки. Конкурсные списки";
$this->params['breadcrumbs'][] = ['label' => 'Настройки приема', 'url' => ['setting-entrant/index']];
$this->params['breadcrumbs'][] = $this->title;

$optionTime = [ 'pluginOptions' => [
    'showSeconds' => true,
    'showMeridian' => false,
    'minuteStep' => 1,
    'secondStep' => 5,
]];
?>

<div class="box">
    <div class="box-header">
        <?= $modelSettingEntrant->string ?>
     </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-job-entrant']); ?>
        <?= $form->field($model, 'date_start')->widget(\kartik\date\DatePicker::class,
            ['pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
                'startDate'=> $modelSettingEntrant->getDateStart(),
                'endDate' =>  $modelSettingEntrant->getDateEnd(),
        ]]); ?>
        <?= $form->field($model, 'date_end')->widget(\kartik\date\DatePicker::class,
            ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'startDate'=> $modelSettingEntrant->getDateStart(),
                'endDate' =>  $modelSettingEntrant->getDateEnd(),
            ]]); ?>
        <?= $form->field($model, 'time_start')->widget(\kartik\time\TimePicker::class, $optionTime); ?>
        <?= $form->field($model, 'time_end')->widget(\kartik\time\TimePicker::class, $optionTime); ?>
        <?= $form->field($model, 'time_start_week')->widget(\kartik\time\TimePicker::class, $optionTime); ?>
        <?= $form->field($model, 'time_end_week')->widget(\kartik\time\TimePicker::class, $optionTime); ?>
        <?= $form->field($model, 'date_ignore')->widget(\kartik\select2\Select2::class, [
            'options' => ['placeholder' => 'Выберите...', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => $modelSettingEntrant->getAllDateWork()
        ]) ?>
        <?= $form->field($model, 'interval')->textInput(); ?>
        <?= $form->field($model, 'is_auto')->checkbox(); ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
