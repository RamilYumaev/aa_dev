<?php


use yii\helpers\Html;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\helpers\DictDisciplineHelper;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $competitive_group_id int */

\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-primary ">
    <div class="box-body">
        <?=Html::a('Добавить', ['dictionary/discipline-competitive-group/create',
                   'competitive_group_id' => $competitive_group_id],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'target' => '#modal', 'data-modalTitle' =>'Добавить дисциплину', 'class'=>'btn btn-primary']) ?>

        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute' => 'discipline_id',
                    'value' => function (DisciplineCompetitiveGroup $model) {
                        return DictDisciplineHelper::disciplineName($model->discipline_id);
                    },
                ],
                'priority',
                ['class' => \yii\grid\ActionColumn::class,
                    'controller' => '/dictionary/discipline-competitive-group',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url,DisciplineCompetitiveGroup $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать дисциплину', 'target' => '#modal']);
                        },
                    ]
                ],
            ]
        ]) ?>
    </div>
</div>



