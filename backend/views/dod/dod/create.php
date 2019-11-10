<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dod\forms\DodCreateForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Все дни открытых дверей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\backend\assets\dod\DodCreateAsset::register($this);
?>
<div class="dod-create">
    <?php $form = ActiveForm::begin(['id' => 'form-dod']); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textarea(['rows' => 3]) ?>

            <?= $form->field($model, 'description')->widget(\mihaildev\ckeditor\CKEditor::class, [
                'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
            ]); ?>

            <?= $form->field($model, 'type')->checkbox() ?>

            <?= $form->field($model, 'faculty_id')->dropDownList($model->facultyList()) ?>

            <?= $form->field($model, 'edu_level')->dropDownList($model->eduLevelsList()) ?>

            <?= $form->field($model, 'aud_number')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textarea(['rows' => 2]) ?>

            <?= $form->field($model, 'photo_report')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
