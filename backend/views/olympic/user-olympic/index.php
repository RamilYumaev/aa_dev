<?php

use common\auth\helpers\UserSchoolHelper;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\helpers\DictClassHelper;
use common\sending\helpers\SendingHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use yii\helpers\Html;

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
\backend\assets\modal\ModalAsset::register($this);
use olympic\helpers\auth\ProfileHelper; ?>
<div class="box">
    <div class="box-header">
        <?php if($olympic->olimpic_id == 61): ?>
            <?=\yii\helpers\Html::a("Выгрузить список в Excel", ["get-report-olympic", "olympicId"=>$olympic->id, 'ext' =>'xlsx'], ["class"=>"btn btn-success"]);?>
            <?=\yii\helpers\Html::a("Ведомость отборочного этапа", ["subjects", "olympicId"=>$olympic->id,], ['data-pjax' => 'w4', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Ведомость отборочного этапа', "class"=>"btn btn-danger"]);?>
        <?php endif; ?>
        <?php if ($olympic->isFormOfPassageInternal()  && $olympic->year == \common\helpers\EduYearHelper::eduYear()): ?>
            <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION, $olympic->id) ? Html::a("Запустить рассылку приглашений",
                ['olympic/olympic-delivery-status/send-invitation-first', 'olympic_id' => $olympic->id], ['class'=>'btn btn-info']) :
                Html::a("Просмотр состояния рассылки (приглашение)",
                    ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                        'typeSending'=> SendingDeliveryStatusHelper::TYPE_SEND_INVITATION], ['class'=>'btn btn-info'])?>
        <?php endif; ?>
        <?=\yii\helpers\Html::a("Выгрузить список в Word", ["get-report-olympic", "olympicId"=>$olympic->id], ["class"=>"btn btn-primary"]);?>
        <?=\yii\helpers\Html::a("Статистика", ["get-statistic", "olympicId"=>$olympic->id], ["class"=>"btn btn-info"]);?>
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
                ['header' => "Учебная организация",
                    'value' => function ($model) use($olympic) {
                        return  DictSchoolsHelper::schoolName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year)) ??
                            DictSchoolsHelper::preSchoolName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year));
                    }
                ],
                ['header' => "Регион",
                    'value' => function ($model) use($olympic) {
                        return  DictSchoolsHelper::regionName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year)) ??
                            DictSchoolsHelper::preRegionName(UserSchoolHelper::userSchoolId($model->user_id, $olympic->year));
                    }
                ],
                ['header' => "Класс/курс",
                    'value' => function ($model) use($olympic) {
                        return DictClassHelper::classFullName(UserSchoolHelper::userClassId($model->user_id, $olympic->year));
                    }
                ],
                ['header' => "Доп. информация",
                    'value' => function ($model)  {
                      if($model->information) {
                          $information = json_decode($model->information, true);
                          return  implode(', ', \dictionary\models\DictDiscipline::find()->select('name')->where(['id' => $information])->column());
                      } else {
                          return 'Отсутствует';
                      }
                    }
                ],
                'created_at:datetime',
                'updated_at:datetime',
               [ 'format' => 'raw',
                       'value' => function($model) use($olympic) {
                  return $olympic->olimpic_id == 61 ?  Html::a('Обновить', ['update', 'id'=> $model->id],
                      ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Редактировать данные', 'class'=>'btn btn-primary']) :"";
               }]
 ],
        ]); ?>
    </div>
</div>
