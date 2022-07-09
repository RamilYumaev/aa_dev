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
                        [
                                'header'=> 'Наличия правильного ответа',
                            'value'=> function (\modules\exam\models\ExamQuestion $model) {
                                return $model->getAnswer() && $model->getAnswerCorrect()->exists() ? 'Да' : "Нет данных";
                            }],
                        [
                            'header'=> 'Количество ответов',
                            'value'=> function (\modules\exam\models\ExamQuestion $model) {
                                return $model->getAnswer() ? $model->getAnswer()->count() : "Нет данных";
                            }],
                        [
                            'header'=> 'Количество правильных ответов',
                            'value'=> function (\modules\exam\models\ExamQuestion $model) {
                                return$model->getAnswer() && $model->getAnswerCorrect()->exists() ? $model->getAnswerCorrect()->count() : "Нет данных";
                            }],
                        [
                            'header'=> 'Наличия вложенного ответа',
                            'value'=> function (\modules\exam\models\ExamQuestion $model) {
                                return $model->getQuestionNested()->exists() ? "Да" : "Нет данных";
                            }],
                    ]]); ?>
            </div>
        </div>
    </div>
</div>