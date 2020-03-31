<?php


use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Целевые организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Cоздать', ['dict-organizations/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['class' => ActionColumn::class,
                        'controller' => "dict-organizations",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
