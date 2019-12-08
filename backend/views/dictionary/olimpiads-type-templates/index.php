<?php

use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;
use olympic\helpers\OlympicHelper;
use dictionary\helpers\TemplatesHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сопоставление шаблонов различным типам олимпиад';
$this->params['breadcrumbs'][] = $this->title;

\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-default">
    <div class="box box-header">
    <?=Html::a('Добавить', ['create',],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
             <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => 'number_of_tours',
                    'value' => function ($model) {
                        return OlympicHelper::numberOfToursName($model->number_of_tours);
                    },
                ],
                ['attribute' => 'form_of_passage',
                    'value' => function ($model) {
                        return OlympicHelper::formOfPassageName($model->form_of_passage);
                    },
                ],
                ['attribute' => 'edu_level_olimp',
                    'value' => function ($model) {
                        return OlympicHelper::levelOlimpName($model->edu_level_olimp);
                    },
                ],
                ['attribute' => 'template_id',
                    'value' => function ($model) {
                        return TemplatesHelper::templatesName($model->template_id);
                    },
                ],
                'year',
            ['class' => \yii\grid\ActionColumn::class,
                'template' => '{update} {delete}',
                'buttons' => [
                        'update' => function ($url,$model) {
                             return Html::a(
                                 '<span class="glyphicon glyphicon-edit"></span>',
                                 $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'target' => '#modal']);
                         },
                     ]
                 ],
               ],
            ]) ?>
    </div>
</div>

