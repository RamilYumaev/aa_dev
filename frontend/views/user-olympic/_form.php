<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $model olympic\forms\OlympicUserInformationForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['id'=> 'form']); ?>
    <div class="alert alert-warning" role="alert">
        <p>
            После нажатия кнопки "Сохранить" Вы в дальнейшем не сможете редактровать данные.
        </p>
    </div>
    <p></p>
<?= $form->field($model, 'subject_one')->dropDownList($model->subjects()) ?>
<?= $form->field($model, 'subject_two')->dropDownList($model->subjects()) ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>