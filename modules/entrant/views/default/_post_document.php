<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<div class="mt-20">
    <h4>Способы подачи документов</h4>
    <?= Html::a("Онлайн", ['post-document/online'],['class'=> 'btn btn-success', 'data'=> ['method' => 'post']])?>
    <?= Html::a("По почте", ['post-document/mail'],['class'=> 'btn btn-info', 'data'=> ['method' => 'post']])?>
    <?= Html::a("ЭЦП", ['post-document/ecp'],['class'=> 'btn btn-warning', 'data'=> ['method' => 'post']])?>
    <?= Html::a("Личный визит", ['post-document/visit'],['class'=> 'btn btn-primary', 'data'=> ['method' => 'post']])?>
</div>
