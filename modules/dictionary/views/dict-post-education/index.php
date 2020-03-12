<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Должности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <p>
            <?= Html::a('Cоздать', ['dict-post-education/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['class' => ActionColumn::class,
                        'controller' => "dict-post-education",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
