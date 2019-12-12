<?php

use olympic\helpers\OlympicHelper;
use dictionary\helpers\DictFacultyHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \olympic\models\Olympic*/
/* @var $searchModel olympic\forms\search\OlympicSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
    <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
            <?= \operator\widgets\adminlte\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['attribute' => 'status',
                        'filter' => $searchModel->statusList(),
                        'value' => function (\olympic\models\Olympic $model) {
                            return \olympic\helpers\OlympicHelper::statusName($model->status);
                        },
                    ],
                    ['class' => \yii\grid\ActionColumn::class,
                         'controller' => 'olympic/olympic',
                        'template' => '{view}'
                    ],
                ]
            ]); ?>
        </div>
    </div>

