<?php

use olympic\helpers\OlympicHelper;
use dictionary\helpers\DictFacultyHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel olympic\forms\search\OlimpicListSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Олимпиады/конкурсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-coml-group-index">

    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= \backend\widgets\adminlte\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'name',
                    ['attribute' => 'form_of_passage',
                        'filter' => $searchModel->formOfPassage(),
                        'value' => function ($model) {
                            return OlympicHelper::formOfPassageName($model->form_of_passage);
                        },
                    ],
                    ['attribute' => 'faculty_id',
                        'filter' => $searchModel->facultyList(),
                        'value' => function ($model) {
                            return DictFacultyHelper::facultyName($model->faculty_id);
                        },
                    ],
                    'year',
                    ['class' => \yii\grid\ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>

