<?php

/* @var $this yii\web\View */
/* @var $model olympic\forms\WebConferenceForm */
/* @var $web olympic\models\WebConference */


$this->title = 'Обновить: ' . $web->name;
$this->params['breadcrumbs'][] = ['label' => 'Вебинары', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>

<div>
    <?= $this->render('_form',['model'=>$model]) ?>
</div>
