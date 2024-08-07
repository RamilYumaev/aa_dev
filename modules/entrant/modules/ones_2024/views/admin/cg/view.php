<?php
use backend\widgets\adminlte\grid\GridView;
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
                ["class" => "btn btn-danger",]
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
            <h3>Конкурсные списки</h3>
        </div>
        <div class="box-body">
            <?= \himiklab\yii2\ajaxedgrid\GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getCompetitiveList()]),
                'addButtons' => [],
                'rowOptions' => function(\modules\entrant\modules\ones_2024\model\CompetitiveList $model){
                    if ($model::isOnOtherSuccess($model->snils_or_id, $model->id)) {
                        return ['class' => 'info'];
                    }
                    else {
                        return ['class' => 'default'];
                    }
                },
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'fio',
                    'number',
                    'snils_or_id',
                    'priority',
                    ['value' => 'subjectMarks', 'header' => 'Баллы за ВИ'],
                    'mark_ai',
                    'sum_ball',
                    ['value' => 'statusName',
                        'attribute' => 'status'
                    ],
                ],
                'actionColumnTemplate' => '',
            ]) ?>
        </div>
    </div>
</div>
