<?php


use yii\widgets\ActiveForm;
use \olympic\helpers\auth\ProfileHelper;
use yii\helpers\Html;
use kartik\select2\Select2;

?>
<div class="container mt-50">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'form-switch-user', 'options' => ['autocomplete' => 'off']]); ?>
            <?= $form->field($model, 'userId')->widget(Select2::class, [
                'data' => ProfileHelper::getAllUserFullNameWithEmail(),
                'options' => ['placeholder' => 'Выберите пользователя'],
                'pluginOptions' => ['allowClear' => true],
            ]); ?>
            <?= Html::submitButton("Переключится", ['class' => 'btn btn-success']) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
