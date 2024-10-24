<?php
/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones_2024\model\FileSS */

use kartik\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = "Файл. Обновление списка";
?>

<div class="box">
    <div class="box-header">
        <h3><?= $this->title ?></h3>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'file')->widget(\kartik\file\FileInput::class, ['language'=> 'ru',
                    'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
                ]);?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>