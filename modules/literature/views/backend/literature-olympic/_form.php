<?php

use kartik\date\DatePicker;
use modules\entrant\helpers\DateFormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\literature\models\LiteratureOlympic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="literature-olympic-form">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <?php if($model->is_success):?>
                <?= $form->field($model, 'code')->textInput() ?>
                <?= $form->field($model, 'mark_end')->textInput() ?>
            <?php endif;?>

            <?= $form->field($model, 'birthday')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()) ?>

            <?= $form->field($model, 'type')->dropDownList($model->getDocuments()) ?>

            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'date_issue')->textInput() ?>

            <?= $form->field($model, 'authority')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget())?>

            <?= $form->field($model, 'region')->dropDownList(\dictionary\helpers\DictRegionHelper::regionList()) ?>

            <?= $form->field($model, 'zone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status_olympic')->dropDownList($model->getOlympicStatuses()) ?>

            <?= $form->field($model, 'mark_olympic')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'grade_number')->dropDownList($model->getGrades()) ?>

            <?= $form->field($model, 'grade_letter')->dropDownList($model->getLetters()) ?>

            <?= $form->field($model, 'grade_performs')->dropDownList($model->getGrades()) ?>

            <?= $form->field($model, 'fio_teacher')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'place_work')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'academic_degree')->dropDownList($model->getAcademicDegreeList()) ?>

            <?= $form->field($model, 'size')->dropDownList($model->getSizes()) ?>

            <?= $form->field($model, 'is_allergy')->checkbox() ?>

            <?= $form->field($model, 'note_allergy')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'is_voz')->checkbox() ?>

            <?= $form->field($model, 'is_need_conditions')->checkbox() ?>

            <?= $form->field($model, 'note_conditions')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'note_special')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'date_arrival')->widget(\kartik\datetime\DateTimePicker::class,
                ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:00'
                ]]); ?>

            <?= $form->field($model, 'type_transport_arrival')->dropDownList($model->getTransports(),['prompt'=> "Выберите транспорт"]) ?>

            <?= $form->field($model, 'place_arrival')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'number_arrival')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'date_departure')->widget(\kartik\datetime\DateTimePicker::class,
                ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:00'
                ]]); ?>

            <?= $form->field($model, 'type_transport_departure')->dropDownList($model->getTransports(), ['prompt'=> "Выберите транспорт"]) ?>

            <?= $form->field($model, 'place_departure')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'number_departure')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
