<?php

use modules\dictionary\helpers\DisciplineExaminerHelper;
use modules\exam\helpers\ExamQuestionGroupHelper;
use testing\helpers\TestQuestionHelper;
use yii\helpers\Html;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model modules\exam\forms\question\ExamQuestionForm*/
/* @var  $id string */
?>
<div class="box">
    <div class="box-body">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'discipline_id')
            ->dropDownList($model->jobEntrant->isCategoryExam()
                ? DisciplineExaminerHelper::listDisciplineReserve($model->jobEntrant->examiner->disciplineColumn)
                : DisciplineExaminerHelper::listDiscipline(),['prompt' => ""]); ?>
        <?= $form->field($model, 'question_group_id')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите группу вопросов',],
            'data' =>$model->question_group_id ? ExamQuestionGroupHelper::listQuestionGroupIds($model->discipline_id) : [],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'text')->widget(CKEditor::class, [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
        ]); ?>
    </div>
    <div class='box-footer'>
        <p id="error-message" style="color: red"></p>
        <?= Html::submitButton('Сохранить',    [ 'id'=> $id, 'class' => 'btn btn-success']) ?>
    </div>
</div>
<?php
$this->registerJs(<<<JS
"use strict";
// фильтруем список конкурсных групп
var disciplineSelect = $('#examquestionform-discipline_id');
var questionGroupSelect = $("#examquestionform-question_group_id");
disciplineSelect.on("change", function() {
    $.ajax({
        url: "/data-exam/exam-question-group/all",
        method: "GET",
        dataType: "json",
        data: {discipline: disciplineSelect.val()},
        async: false,
        success: function(groups) {
            var items = groups.result;
            questionGroupSelect.val("").trigger("change");
            questionGroupSelect.empty();
            questionGroupSelect.append("<option value=''></option>");
            for(var i = 0; i < items.length; ++i) {
                questionGroupSelect.append($("<option></option>").attr("value", items[i].id).text(items[i].text));
            }
        },
        error: function() {
          alert('Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.');
        }
    });
});
disciplineSelect.trigger("init");
JS
);
?>
