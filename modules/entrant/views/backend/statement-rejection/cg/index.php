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

$this->title = "Отозванные заявления о согласии на зачисление";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                            'attribute' => 'statementCg.statement.user_id',
                            'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementConsent('user_id',  'profileUser', 'CONCAT(first_name, \' \', last_name, \' \', patronymic)'), 'user_id', 'statementCg.statement.profileUser.fio'),
                            'value'=> 'statementCg.statement.profileUser.fio'

                    ],
                    [
                            'attribute' => 'cg',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, StatementHelper::columnStatementConsentCg('cg_id',  'fullNameB'), 'cg', 'statementCg.cg.fullNameB'),
                         'label' => "Конкурсная группа",
                         'value' => 'statementCg.cg.fullNameB'
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DateFormatHelper::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to'),
                        'format' => 'datetime',
                    ],
                    [ 'format'=> 'raw' ,
                            'value' => function ( \modules\entrant\models\StatementConsentCg $model) {
                     return Html::tag('span', Html::encode($model->statusNameJob), ['class' => 'label label-'.StatementHelper::colorName($model->status)]);
                    }],
                    ['value' => function ($model) {
                        return Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-eye-open']),
                                ['statement/view', 'id' => $model->statementCg->statement->id],
                                ['data-method' => 'post', 'class' => 'btn btn-info']);
                    }, 'format'=> 'raw' ],
                ],
            ]); ?>
        </div>
    </div>
</div>

