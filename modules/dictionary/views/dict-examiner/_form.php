<?php
/* @var $model modules\dictionary\forms\DictExaminerForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\select2\Select2;
use modules\dictionary\helpers\DisciplineExaminerHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id'=> 'form-dict-organization']); ?>
        <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'disciplineList')->label("Дисциплины")->widget(Select2::class, [
            'options' => ['placeholder' => 'Выберите дисциплины', 'multiple' => true],
            'pluginOptions' => ['allowClear' => true],
            'data' => $model->disciplineList ? DisciplineExaminerHelper::listDisciplineReserve($model->disciplineList) + DisciplineExaminerHelper::listDiscipline() : DisciplineExaminerHelper::listDiscipline(),
        ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
