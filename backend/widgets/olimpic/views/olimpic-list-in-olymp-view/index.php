<?php

use olympic\helpers\OlympicHelper;
use dictionary\helpers\DictFacultyHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \olympic\models\Olympic*/
/* @var $searchModel olympic\forms\search\OlimpicListSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
    <div class="box">
        <div class="box-header">
            <?=   !\common\auth\helpers\UserHelper::isManagerOlympic()  ? Html::a('Cоздать', ['olympic/olimpic-list/create', 'olimpic_id'=> $model->id], ['class' => 'btn btn-success']) : "" ?>
        </div>
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
                    ['value' => function (\olympic\models\OlimpicList $model) {
                    $url = 'olympic/personal-presence-attempt'. ($model->isResultEndTour() ? '/index' : '/create') ;
                    return Html::a('Участники', [ 'olympic/user-olympic/index',
                            'olympic_id' => $model->id], ['class' => 'btn btn-success btn-block'])."</br>".
                        (!$model->isDistanceTour ? Html::a('Ведомость', [
                            $url,
                            'olympic_id' => $model->id], ['class' => 'btn btn-warning btn-block'])."</br>":"").
                        ( !\common\auth\helpers\UserHelper::isManagerOlympic() ?
                        Html::a('Копировать', ['olympic/olimpic-list/copy', 'id' => $model->id], ['class' => 'btn btn-info btn-block']) :"");
                    }, 'format' => "raw"],
                    ['class' => \yii\grid\ActionColumn::class,
                        'controller' => 'olympic/olimpic-list',
                        'template'=> !\common\auth\helpers\UserHelper::isManagerOlympic()  ? "{update} {view} {delete}" : "{view}"
                        ],
                ]
            ]); ?>
        </div>
    </div>

