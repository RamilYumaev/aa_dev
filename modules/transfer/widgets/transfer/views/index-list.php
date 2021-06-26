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
            'attribute' => 'edu_count',
            'value'=> 'eduCount'
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
        ],
        ['class' => ActionColumn::class, 'controller' => 'statement', 'template' => '{view}']
    ],
]); ?>
