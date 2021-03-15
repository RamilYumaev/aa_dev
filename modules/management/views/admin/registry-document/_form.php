<?php
/* @var $model modules\management\forms\RegistryDocumentForm*/
/* @var $form yii\bootstrap\ActiveForm */

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-registry']); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'category_document_id')->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите...'],
            'data' => \modules\management\models\CategoryDocument::find()->allColumn()
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
