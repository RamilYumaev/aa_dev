<?php


use yii\helpers\Html;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $olympic_id int */

\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-primary ">
    <div class="box-body">
        <?=Html::a('Добавить', ['olympic/olimpic-nomination/create',
                   'olimpic_id' => $olympic_id],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить номинацию', 'class'=>'btn btn-primary']) ?>

        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'name',
                ['class' => \yii\grid\ActionColumn::class,
                    'controller' => '/olympic/olimpic-nomination',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, \olympic\models\OlimpicNomination $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать номинацию', 'target' => '#modal']);
                        },
                    ]
                ],
            ]
        ]) ?>
    </div>
</div>



