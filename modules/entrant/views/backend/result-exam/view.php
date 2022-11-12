<?php
/** @var  $cg dictionary\models\DictCompetitiveGroup */
/** @var  $order modules\entrant\models\AisOrderTransfer */
/** @var  $cgDiscipline DisciplineCompetitiveGroup */
use dictionary\models\DisciplineCompetitiveGroup;
use modules\exam\models\Exam;
use modules\exam\models\ExamAttempt;
use yii\helpers\Html;


$this->title = $cg->getFullNameB().'. Результаты экзамена';
$this->params['breadcrumbs'][] = ['label' => 'КГ. Результаты экзамена', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$cgDisciplineArray = DisciplineCompetitiveGroup::find()->where(['competitive_group_id'=> $cg->id ])->select('discipline_id')->column();
$cgDisciplineSpoArray = DisciplineCompetitiveGroup::find()->where(['competitive_group_id'=> $cg->id ])->select('spo_discipline_id')->column();
$examIdArray = Exam::find()->where(['discipline_id'=> array_merge($cgDisciplineArray, $cgDisciplineSpoArray)])->select('id')->column();
?>
<div class="row">
    <div class="box box-primary">
        <div class="box-header"><?= Yii::$app->session->setFlash('warning',
                'Чтобы должность и ФИО были указаны в "Лицо, сформировашее документ", необходимо '.
                \yii\helpers\Html::a('изменить/добавить должность','/profile/entrant-job')); ?></div>
        <div class="box-body">
    <?php $i=0; foreach ($cg->getAisOrderTransfer()->all() as $order): ?>
         <?php if($order->userAis): $userId = $order->userAis->user_id;
           if (ExamAttempt::find()->andWhere(['exam_id'=> $examIdArray, 'user_id' => $userId])->exists()) : ?>
               <div class="col-md-12">
                <p><?= ++$i.". ".$order->userAis->user->profiles->fio ?>
                <?php foreach (DisciplineCompetitiveGroup::find()->where(['competitive_group_id'=> $cg->id ])->orderBy(['priority'=> SORT_ASC])->all() as $cgDiscipline):
                   $exam = Exam::findOne(['discipline_id'=> $cgDiscipline->discipline_id]);
                   $examSpo = Exam::findOne(['discipline_id'=> $cgDiscipline->spo_discipline_id]);
                   $examId = $exam ? $exam->id : 0;
                   $examSpoId = $examSpo ? $examSpo->id : 0;
                   $examAttempt =  ExamAttempt::findOne(['exam_id'=> $examId, 'user_id' => $userId]);
                   $examAttemptSpo =  ExamAttempt::findOne(['exam_id'=> $examSpoId, 'user_id' => $userId]);
                   $examAttemptId = $examAttempt ? $examAttempt->id : 0;
                   $examAttemptSpoId = $examAttemptSpo ? $examAttemptSpo->id : 0;
                    ?>
                <?= $examAttemptId ? Html::a($cgDiscipline->discipline->name, ['pdf', 'cg'=> $cg->id, 'attempt' => $examAttemptId]) : "" ?> |
                        <?= $examAttemptId ? Html::a($cgDiscipline->discipline->name.' (Для печати)', ['view-r', 'cg'=> $cg->id, 'attempt' => $examAttemptId]) : "" ?>
                    <?= $examAttemptSpoId ? Html::a($cgDiscipline->disciplineSpo->name, ['pdf', 'cg'=> $cg->id, 'attempt' => $examAttemptSpoId]) : "" ?> |
                    <?= $examAttemptSpoId ? Html::a($cgDiscipline->disciplineSpo->name.' (Для печати)', ['view-r', 'cg'=> $cg->id, 'attempt' => $examAttemptSpoId]) : "" ?>
                <?php endforeach;?>
                   </p>
               </div>
    <?php endif; endif; endforeach;?>
    </div></div>
</div>
