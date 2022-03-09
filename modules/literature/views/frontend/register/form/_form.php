<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model olympic\forms\SignupOlympicForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;

?>
<div class="container">
    <div class="row">
        <h1>Регистрация на участие в заключительном этапе всероссийской олимпиады школьников по литературе в городе Москва в 2022 году.</h1>
        <div class="col-md-12 mt-30">
            <?php $form = ActiveForm::begin(['id'=> 'form-reg']); ?>
                <?= $this->render('_form_olympic', ['model' => $model->olympic, 'form' => $form]) ?>
                <?= $this->render('_form_person', ['model' => $model->person, 'form' => $form]) ?>
                <?= $form->field($model, 'ids')->hiddenInput()->label('') ?>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

