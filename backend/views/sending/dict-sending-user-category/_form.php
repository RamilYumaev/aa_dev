<?php
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\sending\forms\DictSendingUserCategoryCreateForm | common\sending\forms\DictSendingUserCategoryEditForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

