<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории граждан';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <p>
            <?= Html::a('Cоздать', ['dict-category/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'name',
                ['attribute' => 'foreigner_status',
                    'value' => function ($model) {
                        return $model->foreigner_status ? "Да" : "Нет";
                    }],
                ['class' => ActionColumn::class,
                    'controller' => "dict-category",
                    'template' => '{update} {delete}',
                ],
            ]
        ]); ?>
    </div>
</div>

