<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictSchoolsReport;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictSchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебные организации. Для отчетов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-index">
    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'school_id',
                        'value' => function (DictSchoolsReport $model) {
                            return $model->school->name;
                        },
                    ],
                    ['class' => ActionColumn::class,
                        'template' => '{view} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>

