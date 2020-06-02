<?php
/* @var $this yii\web\View */

use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use olympic\helpers\auth\ProfileHelper;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $type integer */
/* @var $searchModel modules\entrant\searches\ProfilesStatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$type = $type ? " (".AisReturnDataHelper::statusName($type).")" : "";
$this->title = 'Абитуриенты'.$type;

$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'last_name', 'first_name', 'patronymic',
                    ['attribute'=>'gender',
                      'value' => 'genderName',
                        'filter' => ProfileHelper::typeOfGender()
                        ],
                    [  'attribute'=>'country_id',
                        'value' => 'countryName',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, DictCountryHelper::countryListMap(), 'country_id', 'countryName')
                    ],
                    ['attribute'=> 'region_id',
                        'value' => 'regionName',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, DictRegionHelper::regionList(), 'region_id', 'regionName')

                    ],
                    'phone',
                    ['value' => function($model) {
                      return Html::a("Просмотр", ['full', 'user' => $model->user_id], ['class' => 'btn btn-info']);
                      },
                      'format' => "raw",
                      ]
                ]
            ]); ?>
        </div>
    </div>
</div>