<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\auth\forms\SignupForm; */

use yii\captcha\Captcha; ?>
<?= $form->field($model, 'agree')->checkbox([
    'template' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>
                <a href=\"/uploads/consent.pdf\" target=\"_blank\">
                Ознакомиться</a>\n{error}\n{endWrapper}\n{hint}",
]) ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'captchaAction' => ['/sign-up/captcha'],
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6 col-lg-offset-1">{input}</div></div>',
])->hint("Для изменения кода  необходимо кликнуть на картинку") ?>


