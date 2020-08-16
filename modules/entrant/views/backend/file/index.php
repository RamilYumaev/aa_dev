<?php

use modules\entrant\helpers\FileHelper;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\FileSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Файлы. Абитуриенты необработанные";

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                            'attribute' => 'user_id',
                            'filter'  =>SelectDataHelper::dataSearchModel($searchModel, FileHelper::columnFioFile(), 'user_id', 'profileUser.fio'),
                            'value'=> 'profileUser.fio'

                    ],
                    [
                        'attribute' => 'model',
                        'filter' => FileHelper::listName(),
                        'value'=> 'modelName'

                    ],
                    [
                        'attribute' => 'status',
                        'filter' => FileHelper::statusList(),
                        'value'=> 'statusName'

                    ],

                    [
                        'attribute' => 'updated_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],

                    ['value' => function ($model) {
                        return Html::a("Просмотр", ['default/files', 'user' => $model->user_id], ['class' => 'btn btn-info']);

                    },
                        'format' => "raw",
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>

