<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\FileCgHelper;

/* @var $userCg array */

/* @var $statement modules\entrant\models\Statement */

$userCg = FileCgHelper::cgUser($statement->user_id, $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg());
?>

        <table class="table table-bordered" style="font-family: 'Times New Roman'; font-size: 9px">
            <tbody>
            <tr>
                <th>№ п/п</th>
                <th>Направление подготовки</th>
                <th>Образовательная программма</th>
                <th>Форма обучения</th>
                <th>Основание приема</th>
                <th>Федеральный бюджет</th>
                <th>Платное обучение</th>
            </tr>
            <?php foreach ($userCg as $key => $value) :?>
                <tr>
                    <td><?=++$key?></td>
                    <td><?= $value["speciality"] ?></td>
                    <td><?= $value['specialization']?></td>
                    <td><?= $value['form']?></td>
                    <td><?= $value['special_right'] ?></td>
                    <td><h4><?= $value['budget'] ?? "" ?></h4></td>
                    <td><h4><?= $value['contract'] ?? "" ?></h4></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
</div>

