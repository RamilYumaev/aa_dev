<?php
use olympic\helpers\dictionary\DictSpecializationHelper;
use olympic\helpers\dictionary\DictFacultyHelper;
use olympic\helpers\dictionary\DictSpecialityHelper;
use yii\helpers\Html;

$this->title = 'Конкурсные группы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-coml-group-index">

    <h1><?= $this->title ?></h1>

    <p>
        <?= Html::a('Cоздать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= \backend\widgets\adminlte\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['attribute' => 'speciality_id',
                        'filter' => $searchModel->specialityCodeList(),
                        'value' => function ($model) {
                            return DictSpecialityHelper::specialityCodeName($model->speciality_id);
                        },
                    ],
                    ['attribute' => 'specialization_id',
                        'filter' => $searchModel->specializationList(),
                        'value' => function ($model) {
                            return DictSpecializationHelper::specializationName($model->specialization_id);
                        },
                    ],
                    ['attribute' => 'faculty_id',
                        'filter' => $searchModel->facultyList(),
                        'value' => function ($model) {
                            return DictFacultyHelper::facultyName($model->faculty_id);
                        },
                    ],
                    ['class' => \yii\grid\ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>
</div>

