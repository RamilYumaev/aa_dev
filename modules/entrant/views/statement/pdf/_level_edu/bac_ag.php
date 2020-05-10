<?php
/* @var $this yii\web\View */

/* @var $userCg array */
/* @var $statement modules\entrant\models\Statement */

$userCg = FileCgHelper::cgUser($statement->user_id, $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg());

$fontFamily = "font-family: 'Times New Roman';";
$fontSize = "font-size: 9px;";
$borderStyle = "border: 1px solid black;";
$padding = "padding-top: 15px;";
$borderCollapse = "border-collapse: collapse;";
$alignCenter = "align=\"center\"";
$verticalAlign = "vertical-align: middle";
$generalStyle = $borderStyle;

use modules\entrant\helpers\FileCgHelper; ?>

<table class="table table-bordered" style="<?=$fontFamily?> <?=$fontSize?> <?=$borderCollapse?>">
    <tbody>
    <tr>
        <th style="<?=$generalStyle?>" rowspan="2">№</th>
        <th style="<?=$generalStyle?>" colspan="3" align="center">Условия поступления</th>
        <th style="<?=$generalStyle?> <?=$padding?>" rowspan="2" <?=$alignCenter?>>Основание приема</th>
        <th style="<?=$generalStyle?>" align="center" colspan="2">Вид финансирования</th>
    </tr>
    <tr>
        <th style="<?=$generalStyle?>">Направление подготовки</th>
        <th style="<?=$generalStyle?>">Образовательная программма</th>
        <th style="<?=$generalStyle?>">Форма обучения</th>
        <th style="<?=$generalStyle?>">Федеральный бюджет</th>
        <th style="<?=$generalStyle?>">Платное обучение</th>
    </tr>
    <?php foreach ($userCg as $key => $value) :?>
        <tr>
            <td style="<?=$generalStyle?>"><?=++$key?></td>
            <td style="<?=$generalStyle?>"><?= $value["speciality"] ?></td>
            <td style="<?=$generalStyle?>"><?= $value['specialization']?></td>
            <td style="<?=$generalStyle?>" <?=$alignCenter?>><?= $value['form']?></td>
            <td style="<?=$generalStyle?>" <?=$alignCenter?>><?= $value['special_right'] ?></td>
            <td style="<?=$generalStyle?>" <?=$alignCenter?>>
                <?= $value['budget'] ?? "" ?></td>
            <td style="<?=$generalStyle?>" <?=$alignCenter?>><?= $value['contract'] ?? "" ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>