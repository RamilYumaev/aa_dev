<?php

use modules\exam\widgets\exam\TestAttemptStatementWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $examStatement modules\exam\models\ExamStatement*/
/* @var $jobEntrant modules\dictionary\models\JobEntrant */

$jobEntrant = Yii::$app->user->identity->jobEntrant();

$this->title = "Просмотр заявки";
if($jobEntrant && $jobEntrant->isCategoryCOZ()) {
    $this->params['breadcrumbs'][] = ['label' => "Новые заявки на экзамен",
        'url' => ['exam-statement/index']];
    $this->params['breadcrumbs'][] = ['label' => "Мои заявки на экзамен",
        'url' => ['exam-statement/my-list']];
}
if($jobEntrant && $jobEntrant->isCategoryTarget()) {
    $this->params['breadcrumbs'][] = ['label' => "Заявки на экзамен. Нарушения",
        'url' => ['exam-statement/violation']];
}
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\modal\ModalAsset::register($this);

?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box box-header">
                <h4>Данные</h4>
                <?= Html::a('BigBlueButton',  $examStatement->src_bbb,['class'=> "btn bg-purple",  'target'=>'_blank']) ?>
                <?= $jobEntrant && $jobEntrant->isCategoryTarget() &&  $examStatement->statusError() ? Html::a("В резервный день",
                    ['exam-statement/reserve-date', 'id'=> $examStatement->id],['data-pjax' => 'w15', 'data-toggle' => 'modal', 'data-target' => '#modal',
                            'data-modalTitle' =>'Добавить резервную дату', 'class'=> 'btn btn-danger']).($examStatement->getViolation()->count() ? Html::a("Завершить и очистить нарушения",
                        ['exam-statement/reset-violation', 'id'=> $examStatement->id], [ 'class'=> 'btn btn-info', 'data-confirm'=> "Вы уверены, что хотите очистить нарушения и завершить?" ]).
                        Html::a("Аннулировать",
                            ['exam-statement/reset-attempt', 'id'=> $examStatement->id], [ 'class'=> 'btn btn-info', 'data-confirm'=> "Вы уверены, что хотите аннулировать?" ]) : "") : ''?>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $examStatement,
                    'attributes' => [
                        "date:date",
                        "entrantFio",
                        "proctorFio",
                        'exam.discipline.name',
                        'typeName',
                        'statusName',
                        'message'
                    ],
                ]) ?>
            </div>
            <?php if($jobEntrant && $jobEntrant->isCategoryTarget()) : ?>
            <div class="box-footer">
                <?= TestAttemptStatementWidget::widget(['userId'=>  $examStatement->entrant_user_id, 'examId' =>  $examStatement->exam_id, 'type' => $examStatement->type, 'markShow' => true]) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= \modules\exam\widgets\statement\ExamStatementWidget::widget(['examId'=> $examStatement->exam_id, 'userId'=> $examStatement->entrant_user_id]) ?>
    </div>
    <div class="col-md-6">
        <?= \modules\exam\widgets\violation\ExamViolationWidget::widget(['examStatement'=> $examStatement]) ?>
    </div>
</div>