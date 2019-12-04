<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model testing\forms\TestAndQuestionsForm /
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php if ($model->questionGroupList()): ?>
    <?php $form = ActiveForm::begin(['id' => 'test-form',  'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'test_group_id')->widget(Select2::class, [
        'data' => $model->questionGroupList(),
        'options' => ['placeholder' => 'Выберите группу вопросов ', 'multiple' => true],
    ])->label('Группа вопросов') ?>

    <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>
        <?php ActiveForm::end(); ?>
    <?php else :?>
    <h4>У вас нет ни одной группы вопросов, в которой содержатся от 2-х и более вопросов </h4>
    <?php endif;?>
</div>
