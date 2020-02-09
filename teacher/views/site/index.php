<?php
use dictionary\helpers\DictSchoolsHelper;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title= "Главная"
?>
<div class="box">
    <div class="box-header">
        <h4>Благодарности</h4>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'id',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{view}',
                ],
            ]
        ]); ?>
    </div>
</div>
