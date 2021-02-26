<?php


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\TaskUserSearch*/

$this->title = 'Задачи'.$string;
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['task/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
        </div>
    </div>
</div>
