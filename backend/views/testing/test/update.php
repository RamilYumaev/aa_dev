<?php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $testQuestionGroup testing\models\Test */
/* @var $model testing\forms\TestEditForm /
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'test-form']); ?>

    <?= $form->field($model, 'classesList')->widget(Select2::class, [
        'data' => $model->classFullNameList(),
        'options' => ['placeholder' => 'Выберите классы', 'multiple' => true],
    ])->label('Классы') ?>




    <?= $form->field($model, 'introduction')->widget(CKEditor::class, [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
    ]); ?>

    <?= $form->field($model, 'final_review')->widget(CKEditor::class, [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
