<?php

use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementIASearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Заявления об учете индивидуальных достижений";
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
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementIa('user_id',  'profileUser.fio'), 'user_id', 'profileUser.fio'),
                            'value'=> 'profileUser.fio'

                    ],
                    [
                        'attribute' => 'edu_level',
                        'filter' => StatementHelper::columnStatementIa('edu_level',  'eduLevel'),
                        'value'=>'eduLevel',
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    ['class' => ActionColumn::class, 'controller' => 'statement', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

