<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model dictionary\forms\FacultyEditForm */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="faculty-update">
    <?php $form = ActiveForm::begin(['id' => 'form-faculty', 'action'=> Url::to(['dictionary/faculty/update-moderation', 'id' =>$model->_faculty->id])]); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
