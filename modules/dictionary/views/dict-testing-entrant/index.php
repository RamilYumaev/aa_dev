<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\dictionary\searches\DictTestingEntrantSearch */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <p>
            <?= Html::a('Создать', ['dict-testing-entrant/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'=> $searchModel,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'name',
                'is_auto:boolean',
                'priority',
                ['class' => ActionColumn::class,
                    'controller' => "dict-testing-entrant",
                    'template' => '{update} {delete}',
                ],
            ]
        ]); ?>
    </div>
</div>

