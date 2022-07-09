<?php

use backend\widgets\adminlte\grid\GridView;
use entrant\assets\modal\ModalAsset;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\exam\searches\ExamQuestionGroupSearch */

ModalAsset::register($this);
$this->title = 'Группы вопросов';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-default">
    <div class="box-body">
             <?= GridView::widget([
            'dataProvider' => $dataProvider,
                 'filterModel' => $searchModel,
            'columns' => [
                ['class' => SerialColumn::class],
                'name',
                ['attribute' => 'discipline_id',
                    'filter'=> $searchModel->filterDiscipline(),
                    'value'=> 'discipline.name'],
                ['class' => ActionColumn::class, 'controller' => 'exam-question-group', 'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal']);
                        },
                    ]]
            ]]) ?>
    </div>
</div>

