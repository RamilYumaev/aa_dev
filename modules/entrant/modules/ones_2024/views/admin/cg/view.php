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
            <h3>Заявления</h3>
            <?= Html::a(
                'Все приоритеты',
                ['view', 'id'=>$model->id],
                 ["class" => "btn btn-success"]
            );?>
            <?= Html::a(
                'Разные приоритеты',
                ['view', 'id'=>$model->id, 'different' => 1],
                ["class" => "btn btn-warning"]
            );?>
            <?= Html::a(
                'Нет приоритета вуза',
                ['view', 'id'=>$model->id, 'different' => 2],
                ["class" => "btn btn-danger"]
            );?>
        </div>
        <div class="box-body">
            <?=  GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                     ['header' => 'ФИО',
                        'attribute' => 'fio',
                        'value' => 'entrant.fio'
                    ],
                    ['header' => 'СНИЛС',
                        'attribute' => 'snils',
                        'value' => 'entrant.snils'
                    ],
                     'actual',
                     'priority_vuz',
                     'priority_ss',
                     'status',
                     'source',
                     'is_el_original:boolean',
                     'is_paper_original:boolean',
                      ['label' => "#",
                        'format' => 'raw',
                        'value' => function(\modules\entrant\modules\ones_2024\model\EntrantCgAppSS  $model) {
                            return Html::a('Просмотр', ['entrant/view',
                                'id' => $model->entrant->id,]);
                        }],
                ],
            ]) ?>
        </div>
    </div>
</div>
