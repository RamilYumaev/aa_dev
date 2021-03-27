<?php

use  common\auth\helpers\UserSchoolHelper;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\helpers\DictClassHelper;
use common\sending\helpers\SendingHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use dod\helpers\UserDodHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dod \dod\models\DateDod */
$this->title = $dod->dodOne->name;
$this->params['breadcrumbs'][] = ['label' => 'Все дни открытых дверей', 'url' => ['dod/dod/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['dod/dod/view', 'id' => $dod->dodOne->id]];
$this->params['breadcrumbs'][] = $this->title;

use olympic\helpers\auth\ProfileHelper; ?>
<div class="box">
    <div class="box-header">
        <p><?= $dod->formNameTypes ?></p>
        <?php if($dod->haveDateTypes()): ?>
            <p><i><?= $dod->dateStartString ?></i></p>
            <p><i><?= $dod->timeStartString ?></i></p>
        <?php elseif($dod->haveFullInfoTypes() || $dod->haveDateHybridTypes()): ?>
            <p><i><?= $dod->dateStartString ?></i></p>
            <p><i><?= $dod->timeStartString ?></i></p>
            <p><?= $dod->dodOne->addressString ?></p>
            <p><?= $dod->dodOne->audNumberString ?></p>
        <?php endif; ?>
        <?= $dod->dodOne->description ?>
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
                        return ProfileHelper::findProfile($model->user_id)->phone ?? "";
                    }
                ],
                ['header' => "e-mail",
                    'value' => function ($model) {
                        return \common\auth\helpers\UserHelper::getEmailUserId($model->user_id);
                    }
                ],
                ['header' => "e-mail",
                    'value' => function ($model) {
                        return \common\auth\helpers\UserHelper::getEmailUserId($model->user_id);
                    }
                ],
                ['header' => "Учебная организация",
                    'value' => function ($model) {
                        return $model->school_id ?  DictSchoolsHelper::schoolName($model->school_id):'';
                    }
                ],
                ['header' => "Форма участия",
                    'value' => function ($model) {
                        return $model->form_of_participation ?  UserDodHelper::nameParticipationForm($model->form_of_participation):'';
                    }
                ],
                ['header' => "Статус участника",
                    'value' => function ($model) {
                        return $model->status_edu ?  \modules\dictionary\helpers\DictPostEducationHelper::name($model->status_edu):'';
                    }
                ],
                ['header' => "Количество",
                    'value' => function ($model) {
                        return $model->count ?? '';
                    }
                ],
            ],

        ]); ?>
    </div>
</div>
