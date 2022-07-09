<?php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\exam\forms\ExamTestForm/
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'test-form', 'enableAjaxValidation' => true]); ?>
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'introduction')->widget(CKEditor::class, [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
    ]); ?>

    <?= $form->field($model, 'final_review')->widget(CKEditor::class, [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
    ]); ?>

    <?= $form->field($model, 'random_order')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
