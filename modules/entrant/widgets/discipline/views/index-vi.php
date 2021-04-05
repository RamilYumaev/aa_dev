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
            <h4>Вступительные испытания (ВИ) /EГЭ /ЦТ:</h4>
            <?= Html::a('Добавить/Редактировать', ['user-discipline/create-select'], ['class' => 'btn btn-success mb-10']) ?>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Экзамен</th>
                    <th>Дисциплина по выбору</th>
                    <th>Тип</th>
                    <th>Балл</th>
                    <th>Год сдачи</th>
                    <th>Статус ЕГЭ/ЦТ</th>
                </tr>
                <?php $a = 0; foreach ($exams as $key => $exam) :
                    $userDiscipline = UserDiscipline::find()->user($userId)->discipline($key)->one(); ?>
                <?php if($userDiscipline): ?>
                <tr>
                    <td><?= ++ $a ?></td>
                    <td><?= $exam ?></td>
                    <td><?= $userDiscipline->dictDisciplineSelect->name ?></td>
                    <td><?= $userDiscipline->nameShortType ?></td>
                    <td><?= $userDiscipline->year ?></td>
                    <td><?= $userDiscipline->mark ?></td>
                    <td><?= $userDiscipline->status_cse ?></td>
                </tr>
                <?php else: ?>
                <tr  class="danger">
                    <td><?= ++ $a ?></td>
                    <td><?= $exam ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php endif; endforeach; ?>
            </table>
        </div>
    </div>
</div>
