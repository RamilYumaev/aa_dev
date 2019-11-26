<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionForm */
/* @var  $id string '*/
?>
<div class="box">
    <div class="box-body">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'group_id')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите группу вопросов',],
            'data' => $model->groupQuestionsList(),
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
        <?= Html::submitButton('Сохранить', [ 'id'=> $id, 'class' => 'btn btn-success']) ?>
    </div>
</div>
