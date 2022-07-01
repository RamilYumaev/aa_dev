<?php

use rmrevin\yii\fontawesome\component\Icon;
use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\AgreementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\admin\AnketaSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Анкеты";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        ['class' => ActionColumn::class, 'controller' => 'anketa', 'template' => '{update}'],
                    'user_id',
                    [
                        'attribute' => 'surname',
                        'header' => $searchModel->getAttributeLabel('surname'),
                        'value'=> 'profile.last_name'
                    ],
                    [
                        'attribute' => 'name',
                        'header' => $searchModel->getAttributeLabel('name'),
                        'value'=> 'profile.first_name'
                    ],
                    [
                        'attribute' => 'patronymic',
                        'header' => $searchModel->getAttributeLabel('patronymic'),
                        'value'=> 'profile.patronymic'
                    ],
                    [
                        'attribute' => 'phone',
                        'header' => $searchModel->getAttributeLabel('phone'),
                        'value'=> 'profile.phone'
                    ],
                    [
                        'attribute' => 'is_dlnr_ua',
                        'header' => $searchModel->getAttributeLabel('is_dlnr_ua'),
                        'value'=> 'is_dlnr_ua',
                        'format'=> 'boolean'
                    ],
                    [
                        'attribute' => 'email',
                        'value'=> 'user.email'
                    ],
                    [
                        'header'=> 'Статус загрузки в АИС ВУЗ',
                        'value' => function ($model) {
                            return $model->profile->aisUser ? Html::tag("span", "загружен", ['class' => "label label-success"])
                                : Html::tag("span", "не загружен", ['class' => "label label-danger"]);
                        }, 'format' => "raw",],
                    [
                        'header'=> '',
                        'value' => function ($model) {
                            $url =  Html::a("Редактировать данные", \Yii::$app->params['staticHostInfo'] . '/switch-user/by-user-id?id=' . $model->user_id,
                                ['class' => 'btn btn-info', 'target' => '_blank']);
                            return !$model->profile->aisUser ?  Html::a('Очистить данные', ['delete-data', 'id'=> $model->id], [
                                    'class' => 'btn btn-danger', 'data'=> ['method'=> 'post', 'confirm' => 'Вы уверены, что хотите очистить данные?']
                            ]).$url : $url;
                        },
                        'format' => "raw",],
                ],
            ]); ?>
        </div>
    </div>
</div>