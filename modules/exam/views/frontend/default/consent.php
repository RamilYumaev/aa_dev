<?php

/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = "Соглашение";

$this->params['breadcrumbs'][] = ['label' => 'Экзамены', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<center>
<iframe width="900" height="415"
        scrolling="auto"
        src="<?= Yii::getAlias('@frontendInfo/instructions/_text_consent.html')?>">
</iframe>
<?php $form = ActiveForm::begin(['id' => 'edu', 'options' => []]); ?>
<?= Html::checkbox("exam", false ,  ['label'=>'Я принимаю'])?>
<div class="form-group m-10">
        <?= Html::submitButton("Принять", ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
</center>