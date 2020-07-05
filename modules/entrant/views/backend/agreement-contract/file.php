<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\FilePdfForm */

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-file']); ?>
<?= $form->field($model, 'file_name')->widget(FileInput::class, ['language'=> 'ru',
    'options' => ['accept' => 'pdf/*'],
]);?>
<div class="form-group">
    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

