<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model olympic\forms\auth\ProfileCreateForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Ваш профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-30">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <?= $this->render('_form', ['form' => $form, "model"=> $model]) ?>
    <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

