<?php


use dictionary\helpers\DictRegionHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $agreement modules\entrant\models\Agreement */
/* @var $searchModel \modules\dictionary\searches\DictOrganizationsSearch*/

$this->title = "Поиск организаций Заказчика/работодателя.";
$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Договор о целевом обучении', 'url' => ['/abiturient/agreement']];
$this->params['breadcrumbs'][] = $this->title; ?>
<div class="row">
    <?php if ($agreement &&  $agreement->organization && $agreement->organizationWork) : ?>
    <div class="col-md-1">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            ["/abiturient/agreement"], ["class" => "btn btn-success position-fixed btn-lg mt-10 ml-30"]) ?>
    </div>
    <?php endif; ?>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= $this->title ?></h1>
            <div class="box-header">
                <?= Html::a('Создать', ['add-organization'], ['class' => 'btn btn-success']) ?>
            </div>
            <h5>Ваши данные</h5>
            <p><?=  "Заказчик: ".($agreement &&  $agreement->organization ? $agreement->fullOrganization : 'нет данных') ?></p>
            <p><?=  "Работодатель: ".($agreement && $agreement->organizationWork ? $agreement->fullOrganizationWork : 'нет данных')  ?></p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['value' => function($model) {
                        return Html::a('Заказчик', ['select', 'id'=> $model->id, 'status' => 0], ['class' => 'btn btn-info']).'<br />'.
                            Html::a('Работодатель', ['select', 'id'=> $model->id, 'status' => 1], ['class' => 'btn btn-success']).
                            Html::a('Заказчик и Работодатель', ['select', 'id'=> $model->id, 'status' => 2], ['class' => 'btn btn-warning']);
                    }, 'format'=> 'raw'],
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    'kpp',
                    'ogrn',
                    ['attribute'=> 'region_id',
                        'filter'=> DictRegionHelper::regionList(),
                        'value' => 'region.name'
                    ],
                    ['value' => function($model) {
                        return Html::a('Редактировать', ['edit-organization','id' => $model->id], ['class' => 'btn btn-success']);
                    }, 'format'=> 'raw'],
                ]
            ]); ?>
        </div>
    </div>
</div>