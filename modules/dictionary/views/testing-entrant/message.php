<?php
/* @var $model \modules\dictionary\forms\TestingEntrantDictForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id'=> 'form-message', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'message')->textarea() ?>
        <?=  $form->field($model, 'images[]')->widget(FileInput::class, [
                'options' => ['multiple' => true],
        ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>