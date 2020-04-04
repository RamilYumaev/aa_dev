<?php
/* @var $model modules\dictionary\forms\DictIndividualAchievementForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\helpers\EduYearHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\select2\Select2;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-individual-achievement']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'name_short')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'category_id')->dropDownList(DictDefaultHelper::categoryDictIAList()) ?>
        <?= $form->field($model, 'mark')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'year')->dropDownList(EduYearHelper::eduYearList()) ?>
        <?= $this->render('_form_search_cg') ?>
        <?= $form->field($model, 'competitiveGroupsList')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите конкурсные группы', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => $model->competitiveGroupsList ? DictCompetitiveGroupHelper::dictCompetitiveGroupList($model->competitiveGroupsList) : []
        ]) ?>

        <?= $form->field($model, 'documentTypesList')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите виды документов', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => DictIncomingDocumentTypeHelper::listType(DictIncomingDocumentTypeHelper::TYPE_DIPLOMA)
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$financingTypeBudget = DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET;
$this->registerJs(<<<JS
"use strict";
// фильтруем список конкурсных групп
var yearSelect = $('#dictindividualachievementform-year');
var competitiveGroupSelect = $("#dictindividualachievementform-competitivegroupslist");
var filterEducationLevelSelect = $("#filter-education_level_id");
var filterEducationFormSelect = $("#filter-education_form_id");
var filterFinancingTypeSelect = $("#filter-financing_type_id");
var filterFacultySelect = $("#filter-faculty_id");

filterEducationLevelSelect.add(filterEducationLevelSelect).add(filterEducationFormSelect).add(filterFinancingTypeSelect)
    .add(filterFacultySelect).add(yearSelect)
    .on("change", function() {
    $.ajax({
        url: "/dictionary/dict-competitive-group/full-cg",
        method: "GET",
        dataType: "json",
        data: {year: yearSelect.val(), educationLevelId: filterEducationLevelSelect.val(), educationFormId: JSON.stringify(filterEducationFormSelect.val()),
            facultyId: JSON.stringify(filterFacultySelect.val()), foreignerStatus: 0, financingTypeId: {$financingTypeBudget}},
        async: false,
        success: function(competitiveGroups) {
            var items = competitiveGroups.result;
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

