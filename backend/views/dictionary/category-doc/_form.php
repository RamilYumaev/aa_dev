<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\forms\dictionary\CategoryDocForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catDoc-form">

    <?php $form = ActiveForm::begin(['id' => 'form-catDoc']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'type_id')->dropDownList($model->categoryTypeList(),["prompt"=>"Выберите тип категории"]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
