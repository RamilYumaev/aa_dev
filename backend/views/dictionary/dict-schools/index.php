<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictSchools;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictSchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебные организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-index">
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
                    ['attribute' => 'country_id',
                        'filter' => $searchModel->countryList(),
                        'value' => function (DictSchools $model) {
                            return \dictionary\helpers\DictCountryHelper::countryName($model->country_id);
                        },
                    ],
                    ['attribute' => 'region_id',
                        'filter' => $searchModel->regionList(),
                        'value' => function (DictSchools $model) {
                            return \dictionary\helpers\DictRegionHelper::regionName($model->region_id);
                        },
                    ],
                    ['class' => ActionColumn::class,
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>

