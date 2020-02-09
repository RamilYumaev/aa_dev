<?php

use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictSchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $school_id integer */

?>
<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'name',
            ]
        ]); ?>
    </div>
</div>


