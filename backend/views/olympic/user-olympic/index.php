<?php

use  common\auth\helpers\UserSchoolHelper;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\helpers\DictClassHelper;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $this \yii\web\View */
/* @var $olympic \olympic\models\OlimpicList */

$olympicAndYearName =  \olympic\helpers\OlympicListHelper::olympicAndYearName($olympic->id);
$this->title = $olympicAndYearName . '. Участники';
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic->olimpic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic->olimpic_id]];
$this->params['breadcrumbs'][] = ['label' => $olympicAndYearName,
    'url' => ['olympic/olimpic-list/view', 'id'=> $olympic->id]];
$this->params['breadcrumbs'][] = $this->title;

use olympic\helpers\auth\ProfileHelper; ?>
<div class="box">
    <div class="box-header">
        <?=\yii\helpers\Html::a("Выгрузить список в Word", ["get-report-olympic", "olympicId"=>$olympic->id], ["class"=>"btn btn-primary"]);?>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
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
                ],
                ],

        ]); ?>
    </div>
</div>
