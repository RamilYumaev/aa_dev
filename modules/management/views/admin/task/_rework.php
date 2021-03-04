<?php
/* @var $model modules\management\forms\TaskForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $schedule modules\management\models\Schedule*/
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="box">
    <?php $form = ActiveForm::begin(['id'=> 'form-dict-task']); ?>
    <div class="box-body">
        <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>
        <?= $this->render('_work', ['schedule' => $schedule]) ?>
        <?= $form->field($model, 'date_end')->textInput(['readonly'=> true]); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

