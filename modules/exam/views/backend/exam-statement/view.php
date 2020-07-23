<?php

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
                <?= $jobEntrant  ? Html::a("В резервный день",
                    ['exam-statement/reserve-date', 'id'=> $examStatement->id],['data-pjax' => 'w15', 'data-toggle' => 'modal', 'data-target' => '#modal',
                            'data-modalTitle' =>'Добавить резервную дату', 'class'=> 'btn btn-danger']).Html::a("Завершить и очистить нарушения",
                        ['exam-statement/end-violation']) : ''?>
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
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= \modules\exam\widgets\statement\ExamStatementWidget::widget(['examId'=> $examStatement->exam_id, 'userId'=> $examStatement->entrant_user_id]) ?>
    </div>
    <div class="col-md-6">
        <?= \modules\exam\widgets\violation\ExamViolationWidget::widget(['examStatementId'=> $examStatement->id]) ?>
    </div>
</div>