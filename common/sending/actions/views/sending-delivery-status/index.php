<?php

use common\auth\helpers\UserSchoolHelper;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\helpers\DictClassHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type int */

/* @var $this \yii\web\View */
/* @var $olympic \olympic\models\OlimpicList */

$olympicAndYearName =  \olympic\helpers\OlympicListHelper::olympicAndYearName($olympic->id);
$this->title = $olympicAndYearName . '. '. SendingDeliveryStatusHelper::deliveryTypeName($type);
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic->olimpic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic->olimpic_id]];
$this->params['breadcrumbs'][] = ['label' => $olympicAndYearName,
    'url' => ['olympic/olimpic-list/view', 'id'=> $olympic->id]];
$this->params['breadcrumbs'][] = $this->title;

$columns = [['class' => \yii\grid\SerialColumn::class],
    ['header' => "ФИО участника",
        'value' => function ($model) {
            return ProfileHelper::profileFullName($model->user_id);
        }
    ],
    ['header' => "Телефон",
        'value' => function ($model) {
            return ProfileHelper::findProfile($model->user_id)->phone;
        }
    ],
    ['header' => "e-mail",
        'value' => function ($model) {
            return \common\auth\helpers\UserHelper::getEmailUserId($model->user_id);
        }
    ],
    ['header' => "Учебная организация",
        'value' => function ($model) use($olympic) {
            return  DictSchoolsHelper::schoolName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year)) ??
                DictSchoolsHelper::preSchoolName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year));
        }
    ],
    ['header' => "Класс/курс",
        'value' => function ($model) use($olympic) {
            return DictClassHelper::classFullName(UserSchoolHelper::userClassId($model->user_id, $olympic->year));
        }
    ]];

if ($type == SendingDeliveryStatusHelper::TYPE_SEND_GRATITUDE) {
    $columns = array_slice($columns, 0, 4);
}
?>
<div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions' => function( \common\sending\models\SendingDeliveryStatus $model){
                if ($model->isStatusRead()) {
                    return ['class' => 'success'];
                }
            },
            'columns' => $columns
        ]); ?>
    </div>
</div>
