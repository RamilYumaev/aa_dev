<?php

use modules\exam\models\ExamResult;
use testing\helpers\TestQuestionHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var  $attempt  \modules\exam\models\ExamAttempt */
/* @var $isCorrect $boolean */

?>
<div class="box box-default">
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}",
            'tableOptions' => ['class' => 'table table-bordered app-table-left'],
            'rowOptions' => function( ExamResult $model){
                if (($model->question->type_id == TestQuestionHelper::TYPE_ANSWER_DETAILED ||
                        $model->question->type_id == TestQuestionHelper::TYPE_FILE)  &&  is_null($model->mark)) {
                    return ['class' => 'warning'];
                }
                 else {
                     return ['class' => 'default'];
                }
            },
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class,  'header'=> '№ п/п',],
               ['attribute'=>'question_id',
                   'header'=> 'Вопрос',
               'class'=> $isCorrect ? \modules\exam\widgets\exam\gird\ViewAnswerAttemptTestColumn::class
               : \modules\exam\widgets\exam\gird\ViewAnswerAttemptTestNotCorrectColumn::class ],
                ['attribute'=>'mark',
                    'header'=> 'Оценка. Итого: '.$attempt->getResult()->sum('mark'),
                    'value'=> 'mark'],
        ]]) ?>
    </div>
</div>

