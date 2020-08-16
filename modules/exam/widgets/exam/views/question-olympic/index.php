<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Вопросы</h4>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'title',
                ['attribute' => 'type_id',
                  'value' => function ($model) {
                    return \testing\helpers\TestQuestionHelper::typeName($model->type_id);
                  },
                  'format' => 'raw',],
                  'text:html',
                ['attribute' => 'group_id',
                    'value' => function ($model) {
                        return \testing\helpers\TestQuestionGroupHelper::testQuestionGroupName($model->group_id);
                    },
                    'format' => 'raw'],

            ],
        ]) ?>
    </div>
</div>

