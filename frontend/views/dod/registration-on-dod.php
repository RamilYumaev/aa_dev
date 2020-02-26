<?php

/* @var $this yii\web\View */
/* @var $dod dod\models\DateDod */
/* @var $model dod\forms\SignupDodForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;
\frontend\assets\ProfileCreateAsset::register($this);

$this->title = "Регистрация на ". $dod->dodOne->name;
$this->params['breadcrumbs'][] = ['label' => 'Дни открытых дверей', 'url' => ['/dod']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><i><?= $dod->dateStartString ?></i></p>
    <p><i><?= $dod->timeStartString ?></i></p>
    <p><?= $dod->dodOne->addressString ?></p>
    <p><?= $dod->dodOne->audNumberString ?></p>

    <h4><strong>Уже есть учетная запись? <?= Html::a('Войдите', ['account/login']) ?></strong></h4>

    <h4>или заполните следующую форму:</h4>

<?php $form = ActiveForm::begin(['id'=> 'form-reg-dod']); ?>

<?= $form->field($model->profile, 'last_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model->profile, 'first_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model->profile, 'patronymic')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model->profile, 'gender')->dropDownList($model->profile->genderList()) ?>

    <?= $form->field($model->profile, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::class, [
        'jsOptions' => [
            'preferredCountries' => ['ru'],
        ]
    ]) ?>

<?= $form->field($model->profile,  'country_id')->dropDownList($model->profile->countryList(), ['prompt'=> 'Выберите страну']) ?>

<?= $form->field($model->profile,  'region_id')->dropDownList($model->profile->regionList(), ['prompt'=> 'Выберите регион']) ?>

<?= $form->field($model->user, 'username') ?>

<?= $form->field($model->user, 'email') ?>

<?= $form->field($model->user, 'password')->passwordInput() ?>

<?= $form->field($model->user, 'password_repeat')->passwordInput() ?>

<?= $form->field($model->user, 'agree')->checkbox([
    'template' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>
                <a href=\"/uploads/consent.pdf\" target=\"_blank\">
                Ознакомиться</a>\n{error}\n{endWrapper}\n{hint}",
]) ?>

<?= $form->field($model->user, 'verifyCode')->widget(Captcha::className(), [
    'captchaAction' => ['/sign-up/captcha'],
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6 col-lg-offset-1">{input}</div></div>',
]) ?>

<?= $form->field($model, 'dateDodId')->hiddenInput()->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Записаться и создать личный кабинет', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
</div>
