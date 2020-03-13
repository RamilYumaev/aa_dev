<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\auth\forms\SignupForm; */

?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?>




