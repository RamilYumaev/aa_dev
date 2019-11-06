<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \olympic\forms\SignupOlympicForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;
\frontend\assets\RegisterOlympicAsset::register($this);
?>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
    'mask' => '+7(999)999-99-99',]) ?>

    <?= $form->field($model, 'country_id')->dropDownList($model->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model, 'region_id')->dropDownList($model->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model, 'check_region_and_country_school')->checkbox(); ?>

    <?= $form->field($model, 'country_school')->dropDownList($model->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model, 'region_school')->dropDownList($model->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model, 'school_id')->dropDownList([''], ['prompt'=> 'Выберите учебную организацию']) ?>

    <?= $form->field($model, 'class_id')->dropDownList($model->classFullNameList()) ?>

    <?= $form->field($model, 'agree')->checkbox([
        'template' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>
                <a href=\"/uploads/consent.pdf\" target=\"_blank\">
                Ознакомиться</a>\n{error}\n{endWrapper}\n{hint}",
    ]) ?>

    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'captchaAction' => ['/auth/signup/captcha'],
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6 col-lg-offset-1">{input}</div></div>',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

