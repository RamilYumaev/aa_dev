<?php

use modules\exam\models\ExamViolation;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $examStatement \modules\exam\models\ExamStatement */
?>
<div class="box">
    <div class="box-header"><h4>Нарушения</h4>
        <?= $examStatement->statusSuccess() ? Html::a('Добавить', ['exam-violation/create','examStatementId' => $examStatement->id],
            ['data-pjax' => 'w7', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-danger']) : ""?>
    </div>
    <div class="box-header">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
            'columns' => [
            'datetime:datetime',
            'message',
            ['class' => ActionColumn::class, 'controller' => '/data-exam/exam-violation', 'template' => $examStatement->statusSuccess() ? '{delete} {update}' : '',
                'buttons' => [
                    'update' => function ($url, ExamViolation $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"></span>',
                            $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal']);
                    },
                ]]
            ],
        ]); ?>
    </div>
</div>