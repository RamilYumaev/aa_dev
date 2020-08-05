<?php

use modules\entrant\widgets\other\PhotoOtherWidget;
use modules\entrant\widgets\passport\PassportMainWidget;
use modules\exam\helpers\ExamDataExportHelper;
use modules\exam\helpers\ExamHelper;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\Exam;
use modules\exam\models\ExamStatement;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\exam\widgets\exam\TestAttemptStatementWidget;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel modules\exam\searches\ExamSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Экспорт ведомости";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <div class="box-header">
            <?php if(Yii::$app->controller->action->id == 'index' && Yii::$app->user->can('dev')): ?>
                <?= $this->render('_buttons') ?>
            <?php endif;?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function(Exam $model){
                        return ['class' => 'warning'];
                },
                'afterRow' =>function (Exam $model, $key, $index, $grid)
                    {
                        return '<td colspan="2">'.ExamDataExportHelper::linkExport($model->id, ExamStatementHelper::USUAL_TYPE_OCH).'</td>'.
                            '<td colspan="2">'.ExamDataExportHelper::linkExport($model->id, ExamStatementHelper::USUAL_TYPE_ZA_OCH).'</td>'.
                            '<td colspan="2">'."Всего попыток: ".$model->getAttempt()->count().'</td></tr>';
                    },
                'columns' => [
                        ['class' =>SerialColumn::class],
                    ['attribute' => 'discipline_id',
                        'filter'=> $searchModel->filterDiscipline(),
                        'value'=> 'discipline.name'],
                    'time_exam',
                    'date_start:date',
                    'date_end:date',
                    'date_start_reserve:date',
                    'date_end_reserve:date',
                    ['class' => ActionColumn::class, 'controller' => 'exam', 'template' => '{update} {view}']
                ],
            ]); ?>
        </div>
    </div>
</div>
