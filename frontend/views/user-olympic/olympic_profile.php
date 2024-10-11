<?php
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model olympic\forms\OlympicUserProfileForm */
/* @var $olympicId integer */

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin(['id'=> 'form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'olympic_profile_id')->dropDownList(\olympic\helpers\OlympicSpecialityProfileHelper::allProfilesByOlympic($olympicId)) ?>
<?= $form->field($model, 'file')->widget(FileInput::class, ['language'=> 'ru',
    'options' => ['accept' => 'image/*'],
]);?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
