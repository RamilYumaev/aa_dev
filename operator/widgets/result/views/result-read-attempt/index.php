<?php
/* @var $this yii\web\View */
/* @var $model \olympic\models\PersonalPresenceAttempt */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
        <?= \operator\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions' => function( \olympic\models\PersonalPresenceAttempt $model){
                if ($model->isRewardFirstPlace()) {
                    return ['class' => 'success'];
                }
                else if ($model->isRewardSecondPlace()) {
                    return ['class' => 'info'];
                }
                else if ($model->isRewardThirdPlace()) {
                    return ['class' => 'warning'];
                }
            },
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                ['attribute' => "ФИО участника",
                    'class' => \operator\widgets\result\gird\PersonalReadUserAttemptColumn::class,
                ],
                ['attribute' => 'Результат (оценка)',
                    'class' => \operator\widgets\result\gird\PersonalMarkReadAttemptColumn::class,
                ]
                ]
        ]); ?>
    </div>
</div>
