<?php


use common\helpers\DateTimeCpuHelper;
use yii\helpers\Html;
use dod\models\DateDod;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dod_id int */

\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-primary ">
    <div class="box-body">
        <?=Html::a('Добавить дату', ['/dod/date-dod/create',
                   'dod_id' => $dod_id],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить дату', 'class'=>'btn btn-primary']) ?>

        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute' => 'date_time',
                    'value' => function (DateDod $model) {
                        return DateTimeCpuHelper::getDateChpu($model->date_time)
                            . ' в ' . DateTimeCpuHelper::getTimeChpu($model->date_time);
                    },
                ],
                ['attribute' => 'type',
                    'value' => function (DateDod $model) {
                        return \dod\helpers\DateDodHelper::typeName($model->type);
                    },
                ],
                ['class' => \yii\grid\ActionColumn::class,
                    'controller' => '/dod/date-dod',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url,DateDod $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать дату', 'data-target' => '#modal']);
                        },
                    ]
                ],
            ]
        ]) ?>
    </div>
</div>



