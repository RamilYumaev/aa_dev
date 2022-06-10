<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\DictRegionSearch */

$this->title = 'Регионы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <p>
            <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
                'filterModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'name',
                ['attribute' => 'ss_id', 'value' => 'idSS', 'filter' => (new \modules\dictionary\models\DictRegion())->getListSS()],
                ['class' => ActionColumn::class,
                    'controller' => "dict-region",
                    'template' => '{update} {delete}',
                ],
            ]
        ]); ?>
    </div>
</div>

