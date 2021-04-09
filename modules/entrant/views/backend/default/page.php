<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Простая страница';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=  Html::a("Синхронизировать результаты ЕГЭ", ['communication-ais/data-export'], ['data-method' => 'post', 'class' => 'btn btn-success']) ?>
