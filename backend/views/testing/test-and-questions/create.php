<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model testing\forms\TestAndQuestionsForm /
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'test-form']); ?>

    <?= $form->field($model, 'questionList')->widget(Select2::class, [
        'data' => $model->questionList(),
        'options' => ['placeholder' => 'Выберите вопросы/задания ', 'multiple' => true],
    ])->label('Классы') ?>

    <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

        <?php ActiveForm::end(); ?>

</div>
