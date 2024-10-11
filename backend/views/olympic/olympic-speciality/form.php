<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model olympic\models\OlympicSpeciality*/
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-olympic-speciality', 'enableAjaxValidation' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>