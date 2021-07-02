<?php


use dictionary\helpers\DictRegionHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\DictOrganizationsSearch*/

$this->title = "Добавление организаци Заказчика/работодателя.";
$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Договор о целевом обучении', 'url' => ['/abiturient/agreement']];
$this->params['breadcrumbs'][] = ['label' => 'Поиск организаций', 'url' => ['/abiturient/agreement/select-organization']];
$this->params['breadcrumbs'][] = $this->title; ?>
<div class="row">
    <div class="col-md-1">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            ["anketa/step2"], ["class" => "btn btn-success position-fixed btn-lg mt-10 ml-30"]) ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= $this->title ?></h1>
            <?= $this->render('@modules/dictionary/views/dict-organizations/_form', ['model'=> $model]) ?>
        </div>
    </div>
</div>