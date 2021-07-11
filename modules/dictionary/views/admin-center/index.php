<?php


use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\DictOrganizationsSearch*/

$this->title = 'Справочник администраторов центров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['admin-center/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    [ 'attribute' => 'job_entrant_id',
                        'filter' => (new \modules\dictionary\models\AdminCenter())->allColumn(),
                        'value' => 'entrantJob.profileUser.fio'
                    ],
                    [ 'attribute' => 'category',
                        'filter' => \modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories(),
                        'value' => 'categoryName'
                    ],

                    ['class' => ActionColumn::class,
                        'controller' => "admin-center",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
