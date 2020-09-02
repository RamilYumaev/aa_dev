<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\StatementCg;
use modules\exam\helpers\ExamCgUserHelper;
use yii\bootstrap\Modal;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $examList bool | array*/
/* @var $exam modules\exam\models\Exam*/
/* @var $examStatement modules\exam\models\ExamStatement*/
/* @var $test modules\exam\models\ExamTest */
$this->title = "Экзамены";
$this->params['breadcrumbs'][] = $this->title;
$userId = Yii::$app->user->identity->getId();

\frontend\assets\modal\ModalAsset::register($this);
 ?>
<div class="container">
    <h1 align="center"><?= $this->title ?></h1>
    <div class="row">

        <table class="table">
            <tr>
                <th>Наименование</th>
                <th>Дата и время (для очной и очно-заочной формы)</th>
                <th>Дата и время (для заочной формы)</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($examList as $exam) :
                $examStatements = $exam->examStatementUser($userId);
                ?>
                <tr class="info">
                    <td><?= $exam->discipline->name?></td>
                    <td><?= $exam->dateExam ?> <?= $exam->timeExam ?></td>
                    <td><?= $exam->dateExamReserve ?> <?= $exam->timeExamReserve ?></td>
                    <td></td>
                </tr>

                <?php if($examStatements):?>
                <tr>
                    <td colspan="4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Дата и время экзамена</th>
                                <th>Тип завки на экзамен</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                            <?php foreach ($examStatements as $examStatement) :?>
                            <tr>
                                <td><?= $examStatement->dateView ?> <?= $examStatement->time ?></td>
                                <td><?= $examStatement->typeName ?></td>
                                <td><?= $examStatement->statusError() ? ($examStatement->getViolation()->count() ? "Завершен" : "Резервный") : $examStatement->statusName ?></td>
                                <td> <?= $examStatement->src_bbb  && !$examStatement->srcDisabled() ? Html::a("Комната для прокторинга и получениия допуска",  $examStatement->src_bbb  , ["class" => "btn btn-primary", 'target'=>'_blank']) : "" ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <?php if($exam->getExamTest()->count()) :?>
                <tr>
                    <td colspan="4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Наименование теста</th>
                                <th></th>
                            </tr>
                            <?php foreach ($exam->examTest as $test) :?>
                            <tr>
                                <td><?= $test->name ?></td>
                                <td><?= $test->active() ? Html::a("Запустить", ['exam-test/start','id' => $test->id],
                                   ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Экзамен', 'class'=>'btn btn-primary']) : "" ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            <?php endif; endif; endforeach; ?>
        </table>
    </div>
</div>

<?php Modal::begin(['id'=>'modal', 'size'=> Modal::SIZE_LARGE, 'header' => "<h4 id='header-h4'></h4>", 'clientOptions' => ['backdrop' => false]]);
echo "<div id='modalContent'></div>";
Modal::end()?>