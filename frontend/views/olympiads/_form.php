<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model olympic\forms\SignupOlympicForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;
 \frontend\assets\RegisterOlympicAsset::register($this);
?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
    <?= $form->field($model->user, 'username') ?>

    <?= $form->field($model->user, 'email') ?>

    <?= $form->field($model->user, 'password')->passwordInput() ?>

    <?= $form->field($model->user, 'password_repeat')->passwordInput() ?>

    <?= $form->field($model->profile, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->profile, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->profile, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->profile, 'phone')->widget(MaskedInput::class, ['mask' => '+7(999)999-99-99']) ?>

    <?= $form->field($model->profile,  'country_id')->dropDownList($model->profile->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model->profile,  'region_id')->dropDownList($model->profile->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model->schoolUser, 'check_region_and_country_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'country_school')->dropDownList($model->schoolUser->countryList(), ['prompt'=> 'Выберите страну']) ?>

    <?= $form->field($model->schoolUser, 'region_school')->dropDownList($model->schoolUser->regionList(), ['prompt'=> 'Выберите регион']) ?>

    <?= $form->field($model->schoolUser, 'school_id')->widget(\kartik\select2\Select2::class, [
        'data' => '',
        'options' => ['placeholder' => 'Выберите учебную организацию'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);  ?>

    <?= $form->field($model->schoolUser, 'check_new_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'check_rename_school')->checkbox(); ?>

    <?= $form->field($model->schoolUser, 'new_school')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->schoolUser, 'class_id')->dropDownList($model->classFullNameList()) ?>

    <?= $form->field($model->user, 'agree')->checkbox([
        'template' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>
                <a href=\"/uploads/consent.pdf\" target=\"_blank\">
                Ознакомиться</a>\n{error}\n{endWrapper}\n{hint}",
    ]) ?>

    <?= $form->field($model->user, 'verifyCode')->widget(Captcha::className(), [
        'captchaAction' => ['/sign-up/captcha'],
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6 col-lg-offset-1">{input}</div></div>',
    ]) ?>

    <?= $form->field($model, 'idOlympic')->hiddenInput()->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Записаться и создать личный кабинет', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

