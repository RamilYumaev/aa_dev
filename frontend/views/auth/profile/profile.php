<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model olympic\forms\auth\ProfileCreateForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Ваш профиль';
$this->params['breadcrumbs'][] = $this->title;
$userRegOlimpic = false;

\frontend\assets\ProfileAsset::register($this);
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_name')->textInput([!$userRegOlimpic ? '' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput([!$userRegOlimpic ? '' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput([!$userRegOlimpic ? '' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '+7(999)999-99-99',]) ?>

    <?= $form->field($model, 'country_id')->dropDownList($model->countryList()) ?>

    <?= $form->field($model, 'region_id')->dropDownList($model->regionList()) ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>


    <?php ActiveForm::end(); ?>

