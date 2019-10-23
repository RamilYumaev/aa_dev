<?php

use common\models\dictionary\Country;
use common\models\dictionary\Region;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Ваш профиль';
$this->params['breadcrumbs'][] = $this->title;
$userRegOlimpic =false;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_name')->textInput([!$userRegOlimpic ? '' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput([!$userRegOlimpic ? '' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput([!$userRegOlimpic ? '' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
        'mask' => '+7(999)999-99-99',]) ?>

    <?= $form->field($model, 'country_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Country::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите страну, в которой проживаете'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'region_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Region::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите регион'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php if (!$userRegOlimpic) : ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

    <?php endif; ?>

    <?php ActiveForm::end(); ?>

