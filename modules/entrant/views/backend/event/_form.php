<?php
/* @var $model modules\entrant\forms\EventForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\select2\Select2;
use modules\entrant\models\Event;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-event']); ?>
        <?= $form->field($model, 'date')->widget(\kartik\datetime\DateTimePicker::class,
            ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii:00'
            ]]); ?>
        <?= $form->field($model, 'type')->dropDownList((new Event())->getTypes()) ?>
        <?= $this->render('@modules/dictionary/views/dict-individual-achievement/_form_search_cg') ?>
        <?= $form->field($model, 'cg_id')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите конкурсные группы', 'multiple' => true],
            'data' => $model->cg_id ? Event::columnCg() : [],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'src')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name_src')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerJs(<<<JS
"use strict";
// фильтруем список конкурсных групп
var competitiveGroupSelect = $("#eventform-cg_id");
var filterEducationLevelSelect = $("#filter-education_level_id");
var filterEducationFormSelect = $("#filter-education_form_id");
var filterFacultySelect = $("#filter-faculty_id");
var filterSpeciality = $("#filter-speciality_id");

filterEducationLevelSelect.add(filterEducationLevelSelect).add(filterEducationFormSelect)
    .add(filterFacultySelect).add(filterSpeciality)
    .on("change", function() {
    $.ajax({
        url: "/data-entrant/event/full-cg",
        method: "GET",
        dataType: "json",
        data: {educationLevelId: filterEducationLevelSelect.val(), educationFormId: JSON.stringify(filterEducationFormSelect.val()),
            facultyId: JSON.stringify(filterFacultySelect.val()), specialityId: JSON.stringify(filterSpeciality.val()), foreignerStatus: 0},
        async: false,
        success: function(competitiveGroups) {
            var items = competitiveGroups.result;
            console.log(items);
            competitiveGroupSelect.val("").trigger("change");
            competitiveGroupSelect.empty();
            competitiveGroupSelect.append("<option value=''></option>");
            for(var i = 0; i < items.length; ++i) {
                competitiveGroupSelect.append($("<option></option>").attr("value", items[i].id).text(items[i].text));
            }
        },
        error: function() {
          alert('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.');
        }
    });
});
JS
);