<?php

/* @var $this yii\web\View */
/* @var $dod dod\models\DateDod */
/* @var $model dod\forms\SignupDodForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use modules\dictionary\helpers\DictPostEducationHelper;
use dod\helpers\UserDodHelper;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
    <?= $this->render('@frontend/views/olympiads/form/_form_profile', ['model' => $model->profile, 'form' => $form]) ?>
    <?php if ($dod->isTypeRemoteEdu()) :?>
        <?= $this->render('@frontend/views/olympiads/form/_form_school', ['model' => $model->schoolUser, 'form' => $form]) ?>
        <?= $form->field($model->statusDodUser, 'status_edu')->dropDownList(DictPostEducationHelper::listNames())?>
        <?= $form->field($model->statusDodUser, 'count')->textInput()?>
    <?php elseif ($dod->isTypeIntramuralLiveBroadcast()) :?>
        <?= $form->field($model->userTypeParticipation, 'form_of_participation')->dropDownList(UserDodHelper::listParticipationForm())?>
    <?php endif;?>
    <?= $this->render('@frontend/views/olympiads/form/_form_user_before', ['model' => $model->user, 'form' => $form]) ?>
    <?= $this->render('@frontend/views/olympiads/form/_form_user_after', ['model' => $model->user, 'form' => $form]) ?>
    <?= $form->field($model, 'dateDodId')->hiddenInput()->label('') ?>
    <div class="form-group">
        <?= Html::submitButton('Записаться и создать личный кабинет', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
