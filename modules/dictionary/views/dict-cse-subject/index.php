<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use modules\dictionary\models\DictCseSubject;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предметы ЕГЭ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Cоздать', ['dict-cse-subject/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    'min_mark',
                    ['attribute' => 'composite_discipline_status', 'value' =>'compositeDisciplineStatus'],
                    ['attribute' => 'cse_status', 'value' =>'cseStatus'],
                    'ais_id',
                    ['class' => ActionColumn::class,
                        'controller' => "dict-cse-subject",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
