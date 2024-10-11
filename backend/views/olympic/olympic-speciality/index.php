<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel olympic\forms\search\OlympicSpecialitySearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Номинации олимпиады';
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
                [   'header' => 'Количество направлений',
                    'value' => function (\olympic\models\OlympicSpeciality  $model) {
                    return count($model->olympicSpecialityProfiles);
                }],
                ['class' => \yii\grid\ActionColumn::class,
                   'template'=>'{delete} {update}',
                    'buttons' => [
                        'update' => function ($url) {
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
