<?php

use dictionary\helpers\DictSpecializationHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel olympic\forms\search\OlympicSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Олимпиады/конкурсы';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-default">
    <div class="box box-header">
        <?=Html::a('Добавить', ['create',],
            ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
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
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal']);
                        },
                    ]
                ],
            ]
        ]); ?>
    </div>
</div>

