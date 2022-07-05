<?php


use modules\dictionary\helpers\DisciplineExaminerHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\DictExaminerSearch*/

$this->title = 'Справочник председателей экзаменационных комиссий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Cоздать', ['dict-examiner/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    'fio',
                    [
                    'attribute' => 'exams',
                    'filter' => SelectDataHelper::dataSearchModel($searchModel, DisciplineExaminerHelper::listDisciplineAll(), 'exams', 'name'),
                    'header' => 'Дисциплины',
                        'value'=> function (\modules\dictionary\models\DictExaminer $model) {
                            return implode(', ', $model->getDisciplineExaminer()->joinWith('discipline')->select('name')->column());
                        }
                    ],
                    ['class' => ActionColumn::class,
                        'controller' => "dict-examiner",
                        'template' => '{update} {delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
