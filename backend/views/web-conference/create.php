<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model olympic\forms\WebConferenceForm */


$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Вебинары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?= $this->render('_form',['model'=>$model]) ?>
</div>
