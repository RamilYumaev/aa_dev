<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $template dictionary\models\Templates */
/* @var $model dictionary\forms\TemplatesEditForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить: ' . $template->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="faculty-update">
    <?php $form = ActiveForm::begin(['id' => 'form-templates']); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name_for_user')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'type_id')->dropDownList($model->typeTemplatesList()) ?>

            <?= $form->field($model, 'text')->widget(\mihaildev\ckeditor\CKEditor::className(), [
                'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
            ]); ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
