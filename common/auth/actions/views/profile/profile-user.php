<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model olympic\forms\auth\ProfileCreateForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Ваш профиль';
$this->params['breadcrumbs'][] = $this->title;
$isOlympicUser = Yii::$app->user->identity->isUserOlympic();
?>
<div class="container">
    <?php if ($isOlympicUser) : ?>
    <?= Yii::$app->session->setFlash('warning', 'Вы не сможете редактировать профиль, 
    так как у вас имеются записи олимпиады на '. \common\helpers\EduYearHelper::eduYear()) ?>
    <?php endif; ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <?= $this->render('_form', ['form' => $form, "model"=> $model]) ?>
    <div class="form-group">
        <?php if (!$isOlympicUser) : ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

