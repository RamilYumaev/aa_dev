<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dictionary\forms\FacultyCreateForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Факультеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-create">
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
