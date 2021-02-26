<?php

use entrant\assets\modal\ModalAsset;
use modules\exam\helpers\ExamQuestionInTestHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $attempt \modules\exam\models\ExamAttempt */
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */


$column = [
        ['attribute' => 'user_id',
            'value' => $attempt->profile->fio,
        ],
        'test.exam.discipline.name',
        'start:datetime',
        'end:datetime',
        ['attribute' => 'mark',
            'value' => $attempt->mark. " из ". ExamQuestionInTestHelper::markSum($attempt->test_id),
        ],
];
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $attempt,
                    'attributes' => $column,
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <center><h2>Материал вступительного испытания</h2></center>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= modules\exam\widgets\exam\TestResultWidget::widget(['attempt'=>$attempt, 'size'=> 50]) ?>
    </div>
</div>
<h4>Лицо, сформировавшее документ:</h4>
<div class="mt-10">
    <table>
        <tr>
            <td class="bb w-200"><strong><?= $jobEntrant->postName ? mb_strtolower($jobEntrant->postName) : ""?></strong></td>
            <td></td>
            <td class="bb w-200"></td>
            <td></td>
            <td class="bb w-200"><strong><?=  $jobEntrant->postName ? $jobEntrant->profileUser->fio : "" ?></strong></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center fs-7">(Должность)</td>
            <td></td>
            <td class="text-center fs-7">(Подпись)</td>
            <td></td>
            <td class="text-center fs-7">(Фамилия И.О.)</td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<h4>Ответственное лицо <br /> приёмной комиссии:</h4>
<div class="mt-25">
    <table>
        <tr>
            <td class="bb w-200"></td>
            <td></td>
            <td class="bb w-200"></td>
            <td></td>
            <td class="bb w-200"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center fs-7">(Должность)</td>
            <td></td>
            <td class="text-center fs-7">(Подпись)</td>
            <td></td>
            <td class="text-center fs-7">(Фамилия И.О.)</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>М.П.</td>
            <td></td>
        </tr>
    </table>
</div>

