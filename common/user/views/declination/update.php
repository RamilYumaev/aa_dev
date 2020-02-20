<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\auth\forms\DeclinationFioForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-declination', 'enableAjaxValidation' => true]); ?>
    <?= $form->field($model, 'nominative')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'genitive')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'dative')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'accusative')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ablative')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'prepositional')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>