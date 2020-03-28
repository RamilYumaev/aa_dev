<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\dictionary\helpers\DictCseSubjectHelper;


/* @var $this yii\web\View */
/* @var $model dictionary\forms\DictDisciplineCreateForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Дисциплины', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'form-discipline']); ?>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'links')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cse_subject_id')->dropDownList(DictCseSubjectHelper::subjectCseList(), ['prompt'=> "Выберите предмет ЕГЭ"])?>
            <?= $form->field($model, 'ais_id')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
