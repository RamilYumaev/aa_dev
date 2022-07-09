<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model testing\forms\TestAndQuestionsForm /
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'test-form', 'enableAjaxValidation' => true]); ?>
    <?= $form->field($model, 'question_id')->widget(Select2::class, [
        'data' => $model->questionList(),
        'options' => ['placeholder' => 'Выберите вопрос ', 'multiple' => true],
    ])->label('Вопрос') ?>

    <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

        <?php ActiveForm::end(); ?>

</div>
