<?php
/* @var $model modules\management\forms\CommentTaskForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="box">
    <?php $form = ActiveForm::begin(['id'=> 'form-dict-task']); ?>
    <div class="box-body">
        <?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

