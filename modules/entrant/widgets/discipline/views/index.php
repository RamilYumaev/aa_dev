<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\UserDisciplineHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userDisciplines */
/* @var $userDiscipline modules\entrant\models\UserDiscipline */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer */

?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(UserDisciplineHelper::isCorrect($userId)) ?>">
        <div class="p-30 green-border">
            <h4>Результаты ЕГЭ/ЦТ:</h4>
            <?= Html::a('Добавить/Редактировать', ['user-discipline/index'], ['class' => 'btn btn-success mb-10']) ?>
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Предметы</th>
                    <th>Тип</th>
                    <th>Год сдачи ЕГЭ/ЦТ</th>
                    <th>Балл ЕГЭ/ЦТ</th>
                    <th>Статус ЕГЭ/ЦТ</th>
                </tr>
                <?php $a = 0; foreach ($userDisciplines as $userDiscipline) : ?>
                <tr>
                    <td><?= ++ $a ?></td>
                    <td><?= $userDiscipline->dictDisciplineSelect->name ?></td>
                    <td><?= $userDiscipline->nameShortType ?></td>
                    <td><?= $userDiscipline->year ?></td>
                    <td><?= $userDiscipline->mark ?></td>
                    <td><?= $userDiscipline->status_cse ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
