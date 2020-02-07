<?php

use kartik\select2\Select2;
/* @var $this yii\web\View */

/* @var $model teacher\models\searches\UserOlympicSearch */

\teacher\assets\search\SearchAsset::register($this);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>
    <?= $form->field($model, 'year')->dropDownList(\olympic\helpers\OlympicListHelper::olympicListYear()) ?>
    <?= $form->field($model, 'olympiads_id')->widget(Select2::class, [
        'options' => ['placeholder' => 'Выберите олимпиаду'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>
    <?= $form->field($model, 'user_id')->widget(Select2::class, [
        'options' => ['placeholder' => 'Выберите участника'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>
    <?= Html::submitButton('Найти', ['class' => 'clearfix btn btn-success', "style"=>"width:100%"]) ?>
<?php ActiveForm::end(); ?>

