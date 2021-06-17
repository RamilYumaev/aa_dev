<?php

use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\JobEntrantSearch */


$this->title = 'Центр приемной комиссии. Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['job-entrant/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    [
                        'attribute' => 'user_id',
                        'filter' => SelectDataHelper::dataSearchModel($searchModel, \olympic\helpers\auth\ProfileHelper::getVolunteering(), 'user_id', 'profileUser.fio'),
                        'value'=> 'profileUser.fio'
                    ],
                    [
                        'attribute' => 'category_id',
                        'filter' => JobEntrantHelper::listCategories(),
                        'value' => 'category'
                    ],
                    [
                        'attribute' => 'faculty_id',
                        'filter' => \dictionary\helpers\DictFacultyHelper::facultyIncomingList(),
                        'value' => 'faculty.full_name'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => JobEntrantHelper::statusList(),
                        'value' => 'statusName'
                    ],
                    [
                        'value' => 'settingEmail.username'
                    ],

                    ['value' => function (\modules\dictionary\models\JobEntrant $model) {
                          return $model->isStatusDraft() ? Html::a('Активировать', ['job-entrant/status',
                              'id' => $model->id, 'status' => JobEntrantHelper::ACTIVE],['class' => 'btn btn-success']) :
                              Html::a('Деактивировать', ['job-entrant/status',
                                  'id' => $model->id, 'status' => JobEntrantHelper::DRAFT],['class' => 'btn btn-danger']);
                        }, 'format' => 'raw',
                    ],
                    ['class' => ActionColumn::class,
                        'controller' => "job-entrant",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
