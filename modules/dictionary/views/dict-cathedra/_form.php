<?php
/* @var $model modules\dictionary\forms\DictCathedraForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-cathedra']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
