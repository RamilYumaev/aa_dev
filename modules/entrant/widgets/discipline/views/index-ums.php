<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\UserDisciplineHelper;
use modules\entrant\models\UserDiscipline;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exams array */
/* @var $userDiscipline modules\entrant\models\UserDiscipline */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer */

?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(UserDisciplineHelper::isCorrect($userId)) ?>">
        <div class="p-30 green-border">
            <h4>Дисциплины по выбору:</h4>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Экзамен</th>
                    <th>Дисциплина по выбору</th>
                    <th></th>
                </tr>
                <?php $a = 0; foreach ($exams as $key => $exam) :
                    $userDiscipline = UserDiscipline::find()->user($userId)->discipline($key)->one(); ?>
                <?php if($userDiscipline): ?>
                <tr>
                    <td><?= ++ $a ?></td>
                    <td><?= $exam ?></td>
                    <td><?= $userDiscipline->dictDisciplineSelect->name ?></td>
                    <td><?= Html::a('Уточнение',['user-discipline/correction-ums', 'discipline' => $key]) ?></td>
                </tr>
                <?php else: ?>
                <tr  class="danger">
                    <td><?= ++ $a ?></td>
                    <td><?= $exam ?></td>
                    <td></td>
                    <td><?= Html::a('Уточнение',['user-discipline/correction-ums', 'discipline' => $key]) ?></td>
                </tr>
                <?php endif; endforeach; ?>
            </table>
        </div>
    </div>
</div>
