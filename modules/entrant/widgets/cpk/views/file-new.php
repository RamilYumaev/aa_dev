<?php

use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'user_id',
            'value'=> 'profileUser.fio'
        ],
        [
            'attribute' => 'model',
            'value'=> 'modelName'

        ],
        [
            'attribute' => 'updated_at',
            'format' => 'datetime',
        ],

        ['value' => function ($model) {
            return Html::a("Просмотр", ['default/files', 'user' => $model->user_id], ['class' => 'btn btn-info']);
        },
            'format' => "raw",
        ]
    ],
]); ?>
