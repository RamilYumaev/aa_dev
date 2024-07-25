<?php

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones_2024\model\CgSS */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\EntrantAppSearch */
ModalAsset::register($this);
$this->title = "Конкурсная группа. Просмотр. " .$model->name;
$this->params['breadcrumbs'][] = ['label' => '"Конкурсные группы"', 'url' => ['cg/index']];

$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a(
                '<span class="glyphicon glyphicon-pencil"></span>',
                ['update', 'id'=>$model->id],
                ["class" => "btn btn-danger",
                    'data-pjax' => 'w8', 'data-toggle' => 'modal', 'data-target' => '#modal',
                    'data-modalTitle' => 'Обновление']
            );?>
        </div>
        <div class="box-body">
            <?= \yii\widgets\DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'education_level',
                    'education_form',
                    'code_spec',
                    'speciality',
                    'profile',
                    'type',
                    'kcp'
                ],
            ]) ?>
        </div>
    </div>
</div>
<div>
    <div class="box">
        <div class="box-header">
            <h3>Заявления</h3>
        </div>
        <div class="box-body">

        </div>
    </div>
</div>
