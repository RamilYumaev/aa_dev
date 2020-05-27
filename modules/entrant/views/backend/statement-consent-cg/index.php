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
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                            'attribute' => 'statementCg.statement.user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementConsent('user_id',  'profileUser.fio'), 'user_id', 'statementCg.statement.profileUser.fio'),
                            'value'=> 'statementCg.statement.profileUser.fio'

                    ],
                    [
                        'attribute' => 'statementCg.statement.faculty_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementConsent('faculty_id',  'faculty.full_name'), 'faculty_id', 'statementCg.statement.faculty.full_name'),
                         'value' => 'statementCg.statement.faculty.full_name'
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    ['value' => function ($model) {
                        return $model->status == StatementHelper::STATUS_WALT ?
                            Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
                                ['communication/export-statement-consent',
                                    'user' => $model->statementCg->statement->user_id,
                                    'statement' => $model->statementCg->statement->id,
                                    'consent' =>  $model->id],
                                ['data-method' => 'post', 'class' => 'btn btn-info']) : "";
                    }, 'format'=> 'raw' ],
                    ['class' => ActionColumn::class, 'controller' => 'statement', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

