<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $faculty dictionary\models\Faculty */
/* @var $model dictionary\forms\FacultyEditForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Обновить факультет: ' . $faculty->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Факультеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $faculty->full_name, 'url' => ['view', 'id' => $faculty->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="faculty-update">
    <?php $form = ActiveForm::begin(['id' => 'form-faculty']); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'genitive_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'filial')->checkbox(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
