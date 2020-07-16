<?php
/* @var $this yii\web\View */

use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\SelectDataHelper;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $type integer */
/* @var $searchModel modules\entrant\searches\ProfilesPotentialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Потенциальные абитуриенты';

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
                    'anketa.category',
                    ['value' => function (Profiles $model) {
                        return Html::a("Посмотреть данные", \Yii::$app->params['staticHostInfo'].'/switch-user/by-user-id?id=' . $model->user_id,
                            ['class' => 'btn btn-default', 'target' => '_blank']);
                            },
                        'format' => "raw",],
                ]
            ]); ?>
        </div>
    </div>
</div>