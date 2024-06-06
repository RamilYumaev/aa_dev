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
                ? DisciplineExaminerHelper::listDisciplineReserve($model->jobEntrant)
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
        <?= $form->field($model, 'date_range_reserve')->widget(DateRangePicker::class, [
            'convertFormat'=>true,
            'language' => 'ru',
            'id' =>'r_g',
            'pluginOptions'=>[
                "timePicker"=> false,
                "timePicker24Hour"=> false,
                'timePickerIncrement'=>1,
                'locale'=>['format'=>'d.m.Y']
            ]
        ])?>
        <?= $form->field($model, 'time_range_reserve')->widget(DateRangePicker::class, [
            'convertFormat'=>true, 'language' => 'ru',
            'id' =>"t_d",
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
        <?= $form->field($model, 'spec')->checkbox()->label("Специальный экзамен") ?>
        <div id="spec">
            <?= $form->field($model, 'src_bb')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php $this->registerJs(<<<JS
var spec = $("#spec");
var checked = $('#examform-spec');
checked.on("change init", function() {
if (this.checked) {
spec.show()
} else {
spec.hide();}});
checked.trigger("init");
JS
);