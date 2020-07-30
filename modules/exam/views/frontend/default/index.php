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
$this->title =  ExamCgUserHelper::isTimeZa() ? "Экзамены для поступающих на заочную форму" : "Экзамены";
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
                <th>Дата</th>
                <th>Время</th>
                <th></th>
            </tr>
            <?php foreach ($examList as $exam) :
                $examStatements = $exam->examStatementUser($userId);
                ?>
                <?php if (ExamCgUserHelper::isTimeZa()): ?>
                <tr class="info">
                    <td><?= $exam->discipline->name?></td>
                    <td><?= $exam->dateExamReserve ?></td>
                    <td><?= $exam->timeExamReserve ?></td>
                    <td><?= !$examStatements ? Html::a("Регистрация", ["exam-statement/register-za", 'examId'=> $exam->id], ["class" => "btn btn-primary",
                            'data'=>['confirm' => 'Вы уверены, что хотите зарегистрироваться?', 'method'=>'post']]) : ""?>
                    </td>
                </tr>
                <?php else: ?>
                <tr class="info">
                    <td><?= $exam->discipline->name?></td>
                    <td><?= $exam->dateExam ?></td>
                    <td><?= $exam->timeExam ?></td>
                    <td><?= !$examStatements ? Html::a("Регистрация", ["exam-statement/register", 'examId'=> $exam->id], ["class" => "btn btn-primary",
                            'data'=>['confirm' => 'Вы уверены, что хотите зарегистрироваться?', 'method'=>'post']]) : ""?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php if($examStatements):?>
                <tr>
                    <td colspan="4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Дата экзамена</th>
                                <th>Тип завки на экзамен</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                            <?php foreach ($examStatements as $examStatement) :?>
                            <tr>
                                <td><?= $examStatement->dateView ?></td>
                                <td><?= $examStatement->typeName ?></td>
                                <td><?= $examStatement->statusName ?></td>
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