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
<div class="box">
    <div class="box-header">Последние заявки на данный экзамен</div>
    <div class="box-body">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
            'columns' => [
            'date:date',
            'proctorFio',
            'typeName',
            'statusName',
            ['class' => ActionColumn::class, 'controller' => '/data-exam/exam-statement', 'template' => '{view}']
            ],
        ]); ?>
    </div>
</div>
