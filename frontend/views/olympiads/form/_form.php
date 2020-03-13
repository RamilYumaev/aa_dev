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

    <?= $this->render('_form_user_before', ['model' => $model->user, 'form' => $form]) ?>

    <?= $this->render('_form_profile', ['model' => $model->profile, 'form' => $form]) ?>

    <?= $this->render('_form_school', ['model' => $model->schoolUser, 'form' => $form]) ?>

    <?= $form->field($model->schoolUser, 'class_id')->dropDownList($model->classFullNameList()) ?>

    <?= $this->render('_form_user_after', ['model' => $model->user, 'form' => $form]) ?>

    <?= $form->field($model, 'idOlympic')->hiddenInput()->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Записаться и создать личный кабинет', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

