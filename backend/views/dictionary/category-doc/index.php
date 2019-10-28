<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use dictionary\models\CategoryDoc;
use dictionary\helpers\CategoryDocHelper;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\CategoryDocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории документов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

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
                    'name',
                    ['attribute' => 'type_id',
                        'filter' => $searchModel->categoryTypeList(),
                        'value' => function (CategoryDoc $model) {
                            return CategoryDocHelper::categoryDocTypeName($model->type_id);
                        },
                    ],
                    ['class' => ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>
