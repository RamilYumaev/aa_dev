<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Классы/курсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['attribute' => 'name',
                        'value' => function (DictClass $model) {
                            return $model->getClassFullName();
                        },
                    ],
                    ['class' => ActionColumn::class,
                     'template'=>'{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>

