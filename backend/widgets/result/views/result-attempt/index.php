<?php
/* @var $this yii\web\View */
/* @var $model \olympic\models\PersonalPresenceAttempt */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions' => function( \olympic\models\PersonalPresenceAttempt $model){
                if ($model->isPresence()) {
                    return ['class' => 'success'];
                }
                else if ($model->isPresenceStatusNull()) {
                    return ['class' => 'default'];
                }
                else if ($model->isNonAppearance()) {
                    return ['class' => 'warning'];
                }
            },
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute' => "ФИО участника",
                    'class' => \backend\widgets\result\gird\PersonalUserAttemptColumn::class,
                ],
                ['attribute' => 'Результат (оценка)',
                    'class' => \backend\widgets\result\gird\PersonalMarkAttemptColumn::class,
                ]
                ]
        ]); ?>
    </div>
</div>
