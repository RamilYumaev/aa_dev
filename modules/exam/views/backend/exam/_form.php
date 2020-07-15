<?php
/* @var $model modules\exam\forms\ExamForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\daterange\DateRangePicker;
use modules\dictionary\helpers\DisciplineExaminerHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-exam']); ?>
        <?= $form->field($model, 'discipline_id')
            ->dropDownList($model->jobEntrant->isCategoryExam()
                ? DisciplineExaminerHelper::listDisciplineReserve($model->jobEntrant->examiner->disciplineColumn)
                : DisciplineExaminerHelper::listDiscipline()); ?>
        <?= $form->field($model, 'time_exam')->textInput(); ?>
        <?= $form->field($model, 'date_range')->widget(DateRangePicker::class, [
            'convertFormat'=>true,
            'language' => 'ru',
            'pluginOptions'=>[
                "timePicker"=> false,
                "timePicker24Hour"=> false,
                'timePickerIncrement'=>1,
                'locale'=>['format'=>'d.m.Y']
            ]
        ])?>
        <?= $form->field($model, 'time_range')->widget(DateRangePicker::class, [
            'convertFormat'=>true, 'language' => 'ru',
            'pluginOptions'=>[
                    'datePicker'=>false,
                "timePicker"=> true,
                "timePicker24Hour"=> true,
                'timePickerIncrement'=>5,
                'locale'=>['format'=>'H:i:s',]
            ],
            'pluginEvents' => [
                    "show.daterangepicker" => "function(ev, picker) {
                       picker.container.find('.calendar-table').hide();
                    }",
                ],

        ])?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
