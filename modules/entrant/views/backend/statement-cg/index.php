<?php

use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementConsentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Заявление о согласии на зачисление";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                     [ 'attribute' =>'cg_id',
                         'filter' => SelectDataHelper::dataSearchModel($searchModel,
                             StatementHelper::columnStatementCg('cg_id',  'cg.fullName'), 'cg_id', 'cg.fullName'),
                         'value' => 'cg.fullName'],
                    ['class' => ActionColumn::class, 'controller' => 'statement-cg', 'template' => '{view}',
                      'buttons' =>  ['view' => function ($url, $model) {
                      return  Html::a('Просмотр', ['view', 'id' => $model->cg_id]);
                      },]
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>

