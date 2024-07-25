<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\CgSSSearch */

$this->title = 'Файлы';
$this->params['breadcrumbs'][] = $this->title;
 ?>
<div>
    <div class="box">
        <div class="box-body table-responsive">
            <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'file_name',
                    'type',
                    'created_at:datetime'
                ]
            ]) ?>
        </div>
    </div>
</div>
<?php
