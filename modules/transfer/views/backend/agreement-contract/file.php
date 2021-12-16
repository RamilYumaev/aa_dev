<?php
/* @var $this yii\web\View */
/* @var $model modules\transfer\forms\FilePdfForm */

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>
<?php $form = ActiveForm::begin(['id'=> 'form-file']); ?>
<?= $form->field($model, 'file_name')->widget(FileInput::class, ['language'=> 'ru',
    'options' => ['accept' => 'pdf/*'],
]);?>
<?php if($model->getScenario() == $model::NUMBER) : ?>
<?= $form->field($model, 'text')->textInput() ?>
<?php endif; ?>
<div class="form-group">
    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

