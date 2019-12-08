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
            <?= Html::a('Cоздать', ['olympic/olimpic-list/create', 'olimpic_id'=> $model->id], ['class' => 'btn btn-success']) ?>
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
                    ['value' => function ($model) { return Html::a('Участники', [ 'olympic/user-olympic/index',
                            'olympic_id' => $model->id], ['class' => 'btn btn-success']);
                    }, 'format' => "raw"],
                    ['value' => function($model) {
                        $url = 'olympic/personal-presence-attempt'.
                            (\olympic\helpers\PersonalPresenceAttemptHelper::isPersonalAttemptOlympic($model->id) ? '/index' : '/create' );
                        return Html::a('Ведомость', [
                                $url,
                            'olympic_id' => $model->id], ['class' => 'btn btn-warning']);
                    }, 'format' => "raw"],
                    ['value' => function($model) {
                        return Html::a('Копировать', ['olympic/olimpic-list/copy', 'id' => $model->id], ['class' => 'btn btn-info']);
                    }, 'format' => "raw"],
                    ['class' => \yii\grid\ActionColumn::class,
                        'controller' => 'olympic/olimpic-list'],
                ]
            ]); ?>
        </div>
    </div>

