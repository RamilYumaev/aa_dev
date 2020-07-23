<?php

/* @var $searchModel \modules\exam\searches\ExamQuestionSearch */

use modules\exam\helpers\ExamQuestionHelper;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use yii\grid\ActionColumn;

?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => \yii\grid\SerialColumn::class],
                        'id',
                        'title',
                        ['attribute' => 'type_id',
                            'filter'=> ExamQuestionHelper::getAllTypesExam(),
                            'value'=> 'typeName'],
                        ['attribute' => 'question_group_id',
                            'filter'=> $searchModel->filterQuestionGroup(),
                            'value'=> 'questionGroup.name'],
                        ['attribute' => 'discipline_id',
                            'filter'=> $searchModel->filterDiscipline(),
                            'value'=> 'discipline.name'],
                        ['class' => ActionColumn::class,
                            'controller' => 'exam-question',
                            'template' => '{update} {delete}',
                        ]]]); ?>
            </div>
        </div>
    </div>
</div>