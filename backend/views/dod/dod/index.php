<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dod\forms\search\DodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все дни открытых дверей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dod-index">
    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['class' => ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>

