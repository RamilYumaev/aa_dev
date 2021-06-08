<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\UserDisciplineHelper;
use modules\entrant\models\UserDiscipline;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exams array */
/* @var $userDisciplines */
/* @var $userDiscipline modules\entrant\models\UserDiscipline */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer */

?>
<?php if($userDisciplines):?>
<?php Box::begin(
    ["header" => "ЕГЭ, ЦТ, ВИ", "type" => Box::TYPE_PRIMARY,
        "collapsable" => true,
    ]
)
?>
<div class="row">
    <div class="col-md-12">
        <div class="p-30 green-border">
            <h4>Вступительные испытания (ВИ) /EГЭ /ЦТ:</h4>
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
                    <?php $a = 0; foreach ($userDisciplines as $userDiscipline) : ?>
                        <tr>
                            <td><?= ++ $a ?></td>
                            <td><?= $userDiscipline->dictDiscipline->name ?></td>
                            <td><?= $userDiscipline->dictDisciplineSelect->name ?></td>
                            <td><?= $userDiscipline->nameShortType ?></td>
                            <td><?= $userDiscipline->year ?></td>
                            <td><?= $userDiscipline->mark ?></td>
                            <td><?= $userDiscipline->statusName ?></td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
    <?php  Box::end(); endif;?>