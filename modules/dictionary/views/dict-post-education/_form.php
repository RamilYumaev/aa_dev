<?php
/* @var $model modules\dictionary\forms\DictPostEducationForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-post-education']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
