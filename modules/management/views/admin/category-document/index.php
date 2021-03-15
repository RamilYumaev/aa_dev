<?php


use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\CategoryDocumentSearch*/

$this->title = 'Справочник категорий документов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['category-document/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['class' => ActionColumn::class,
                        'controller' => "category-document",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
