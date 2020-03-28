<?php
/* @var $model modules\entrant\forms\AddressForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id'=> 'form-ecp',
                'enableClientValidation' => false,
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],]); ?>
            <?= $form->field($model, 'file_name')->widget(FileInput::class, [
                'options' => ['accept' => 'image/*'],
            ]);?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>