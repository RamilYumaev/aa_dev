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
/* @var $dateDod \dod\models\DateDod */

$this->title = $dateDod->dodOne->name." ". $dateDod->getDateStartString(). " ".SendingDeliveryStatusHelper::deliveryTypeName($type);
$this->params['breadcrumbs'][] = ['label' => 'Все дни открытых дверей', 'url' => ['dod/dod/index']];
$this->params['breadcrumbs'][] = ['label' =>  $dateDod->dodOne->name, 'url' => ['dod/dod/view', 'id'=> $dateDod->dodOne->id]];
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
    ]];
?>

<?= $this->render("_data_provider",['columns'=> $columns, 'dataProvider'=> $dataProvider ]) ?>

