<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model olympic\forms\auth\ProfileCreateForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Ваш профиль';
$this->params['breadcrumbs'][] = $this->title;

\frontend\assets\ProfileAsset::register($this);
$isOlympicUser = Yii::$app->user->identity->isUserOlympic();
?>
<div class="container">
    <?php if ($isOlympicUser) : ?>
    <?= Yii::$app->session->setFlash('warning', 'Вы не сможете редактировать профиль, 
    так как у вас имеются записи олимпиады на '. \common\helpers\EduYearHelper::eduYear()) ?>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '+7(999)999-99-99',]) ?>

    <?= $form->field($model, 'country_id')->dropDownList($model->countryList()) ?>

    <?= $form->field($model, 'region_id')->dropDownList($model->regionList()) ?>


        <div class="form-group">
            <?php if (!$isOlympicUser) : ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>


    <?php ActiveForm::end(); ?>

