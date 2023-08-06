<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones\model\CompetitiveList */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="box">
    <div class="box-header">
        <h3><?= $this->title ?></h3>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'number')->textInput() ?>
                <?= $form->field($model, 'fio')->textInput() ?>
                <?= $form->field($model, 'snils_or_id')->textInput() ?>
                <?= $form->field($model, 'cg_id')->widget(Select2::class, [
                    'data' => \modules\entrant\modules\ones\model\CompetitiveGroupOnes::allCgName(),
                    'options' => ['placeholder' => 'Выберите конкурсную группу'],
                ]) ?>
                <?= $form->field($model, 'priority')->textInput() ?>
                <?= $form->field($model, 'mark_ai')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'exam_1')->textInput() ?>
                <?= $form->field($model, 'ball_exam_1')->textInput() ?>
                <?= $form->field($model, 'exam_2')->textInput() ?>
                <?= $form->field($model, 'ball_exam_2')->textInput() ?>
                <?= $form->field($model, 'exam_3')->textInput() ?>
                <?= $form->field($model, 'ball_exam_3')->textInput() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
