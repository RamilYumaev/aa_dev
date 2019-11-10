<?php

use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Председатели';
$this->params['breadcrumbs'][] = $this->title;

\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-default">
    <div class="box box-header">
    <?=Html::a('Добавить', ['create',],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
             <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
            'last_name',
            'first_name',
            'patronymic',
            'position',
                [
                    'value' => function (\dictionary\models\DictChairmans $model) {
                        return $model->photo ? Html::img($model->getThumbFileUrl('photo', 'admin')) : "Нет подписи";
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width: 100px'],
                ],
            ['class' => \yii\grid\ActionColumn::class,
                'template' => '{update} {delete}',
                'buttons' => [
                        'update' => function ($url,$model) {
                             return Html::a(
                                 '<span class="glyphicon glyphicon-edit"></span>',
                                 $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'target' => '#modal']);
                         },
                     ]
                 ],
               ],
            ]) ?>
    </div>
</div>

