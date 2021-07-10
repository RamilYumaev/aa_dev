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
        ['value' => function (\modules\entrant\models\File $model) {
            if($model->model == \modules\entrant\models\Statement::class) {
                return Html::a("Просмотр", ['data-entrant/statement/view', 'id' => $model->record_id], ['class' => 'btn btn-info']);
            }elseif($model->model == \modules\entrant\models\Agreement::class) {
                return Html::a("Просмотр", ['data-entrant/agreement/view', 'id' => $model->record_id], ['class' => 'btn btn-info']);
            }else {
                return Html::a("Просмотр", ['data-entrant/default/files', 'user' => $model->user_id], ['class' => 'btn btn-info']);
            }
        },
            'format' => "raw",
        ]
    ],
]); ?>
