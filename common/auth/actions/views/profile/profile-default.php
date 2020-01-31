<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model olympic\forms\auth\ProfileCreateForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = 'Ваш профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <?= $this->render('_form', ['form' => $form, "model"=> $model]) ?>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

