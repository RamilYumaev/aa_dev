<?php

/* @var $model modules\entrant\forms\CseSubjectResultForm */
/* @var $isKeys array */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictCseSubjectHelper;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-cse-subject-add', 'enableAjaxValidation' => true]); ?>
    <?= $form->field($model, "subject_id")->dropDownList(DictCseSubjectHelper::subjectCseUserList($isKeys)) ?>
    <?= $form->field($model, "mark")->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>



