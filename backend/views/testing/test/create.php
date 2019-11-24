<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model testing\forms\TestCreateForm /
/* @var $form yii\widgets\ActiveForm */

?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'test-form']); ?>

    <?= $form->field($model, 'classesList')->widget(Select2::class, [
        'data' => $model->classFullNameList(),
        'options' => ['placeholder' => 'Выберите классы', 'multiple' => true],
    ])->label('Классы') ?>

    <?= $form->field($model, 'questionGroupsList')->widget(Select2::class, [
        'data' => $model->testQuestionGroupList(),
        'options' => ['placeholder' => 'Выберите группы вопросов', 'multiple' => true],
    ])->label('Группы вопросов') ?>

    <?php if ($model->isFormOcnoZaochno()) : ?>
        <?= $form->field($model, 'type_calculate_id')->dropDownList($model->typeCalculateList()); ?>
        <?= $form->field($model, 'calculate_value')->textInput(['enabled'=> true]) ?>
    <?php endif; ?>

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
