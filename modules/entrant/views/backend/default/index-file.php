<?php
/* @var $this yii\web\View */

use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use modules\entrant\helpers\SelectDataHelper;
use olympic\helpers\auth\ProfileHelper;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $type integer */
/* @var $searchModel modules\entrant\searches\ProfilesFileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Абитуриенты c отклоненными файлами';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <div class="box">
        <div class="box-header"></div>
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'user_id',
                    'last_name', 'first_name', 'patronymic',
                    ['attribute' => 'gender',
                        'value' => 'genderName',
                        'filter' => ProfileHelper::typeOfGender()
                    ],
                    ['attribute' => 'country_id',
                        'value' => 'countryName',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, DictCountryHelper::countryListMap(), 'country_id', 'countryName')
                    ],
                    ['attribute' => 'region_id',
                        'value' => 'regionName',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, DictRegionHelper::regionList(), 'region_id', 'regionName')
                    ],
                    'phone',
                    ['value' => function ($model) {
                        return Html::a("Просмотр", ['files', 'user' => $model->user_id], ['class' => 'btn btn-info']);

                    },
                        'format' => "raw",
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>