<?php
/* @var $model modules\entrant\forms\FileForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-file',
    //'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'options' => [
        'enctype' => 'multipart/form-data',
    ],]); ?>
    <?= $form->field($model, 'file_name')->widget(FileInput::class, ['language'=> 'ru',
        'options' => ['accept' => 'image/*'],
    ]);?>
    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>