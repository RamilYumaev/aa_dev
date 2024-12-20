-<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\FacultySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Факультеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-index">
    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'full_name',
                    ['class' => ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>

