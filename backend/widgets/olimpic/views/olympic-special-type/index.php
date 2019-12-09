<?php


use yii\helpers\Html;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $olympic_id int */

\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-primary ">
    <div class="box-body">
        <?=Html::a('Добавить', ['olympic/special-type-olimpic/create',
                   'olimpic_id' => $olympic_id],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить cпециальный вид олимпиады', 'class'=>'btn btn-primary']) ?>

        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute' => 'special_type_id',
                    'value' => function ( \olympic\models\SpecialTypeOlimpic $model) {
                        return \dictionary\helpers\DictSpecialTypeOlimpicHelper::specialTypeOlimpicName($model->special_type_id);
                    },
                ],
                ['class' => \yii\grid\ActionColumn::class,
                    'controller' => '/olympic/special-type-olimpic',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, \olympic\models\SpecialTypeOlimpic $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать cпециальный вид олимпиады', 'data-target' => '#modal']);
                        },
                    ]
                ],
            ]
        ]) ?>
    </div>
</div>



