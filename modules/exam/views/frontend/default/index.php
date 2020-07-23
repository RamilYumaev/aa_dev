<?php

/* @var $this yii\web\View */
/* @var $examList bool | array*/
/* @var $exam modules\exam\models\Exam*/
/* @var $examStatement modules\exam\models\ExamStatement*/
/* @var $test modules\exam\models\ExamTest */
$this->title = "Экзамены";
$this->params['breadcrumbs'][] = $this->title;
$userId = Yii::$app->user->identity->getId();

use yii\helpers\Html;  var_dump(\modules\exam\helpers\ExamStatementHelper::entrantList());?>
<div class="container">
    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]). " Карточка",
                "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
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
                $examStatement = $exam->examStatementUser($userId);
                ?>
                <tr>
                    <td><?= $exam->discipline->name?></td>
                    <td><?= $exam->dateExam ?></td>
                    <td><?= $exam->timeExam ?></td>
                    <td><?= !$examStatement ? Html::a("Регистрация", ["exam-statement/register", 'examId'=> $exam->id], ["class" => "btn btn-primary",
                            'data'=>['confirm' => 'Вы уверены, что хотите зарегистрироваться?', 'method'=>'post']]) : ""?>
                    </td>
                </tr>
                <?php if(!$examStatement):?>
                <tr>
                    <td colspan="4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Наименовнаие теста</th>
                                <th></th>
                            </tr>
                            <?php foreach ($exam->examTest as $test) :?>
                            <tr>
                                <td><?= $test->name ?></td>
                                <td><?= Html::a("Запустить", "/exam-test", ["class" => "btn btn-primary",
                                        'data'=>['confirm' => 'Вы уверены, что хотите начать экзамен?', 'method'=>'post']]) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            <?php endif; endforeach; ?>
        </table>
    </div>
</div>
