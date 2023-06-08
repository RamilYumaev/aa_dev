<?php
/* @var $model modules\entrant\forms\AgreementClarifyCgForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
?>
<?php $form = ActiveForm::begin(['id'=> 'clarify-form']); ?>
<?= $form->field($model, 'competitive_list')
    ->widget(\kartik\select2\Select2::class,
    ['data' => $model->getEntrantCg(),
        'options'=> ['placeholder'=> 'Выберите конкурсные группы абитуриента','multiple' => true]]);?>
    <div class="form-group">
        <?= Html::submitButton('Уточнить', ['class' => 'btn btn-info']) ?>
    </div>
<?php ActiveForm::end(); ?>