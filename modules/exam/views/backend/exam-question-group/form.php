<?php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use modules\dictionary\helpers\DisciplineExaminerHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\exam\forms\ExamQuestionGroupForm/
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'question-group', 'enableAjaxValidation' => true]); ?>
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'discipline_id')
        ->dropDownList($model->jobEntrant->isCategoryExam()
            ? DisciplineExaminerHelper::listDisciplineReserve($model->jobEntrant->examiner->disciplineColumn)
            : DisciplineExaminerHelper::listDiscipline()); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
