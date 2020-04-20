<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;
use modules\entrant\helpers\PostDocumentHelper;
/* @var $this yii\web\View */
/* @var $userCg yii\db\BaseActiveRecord */
?>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Факультет</th>
        <th>Направление подготовки</th>
        <th>Уровень образования</th>
        <th>Основание приема</th>
    </tr>
    <?php foreach ($userCg as $key => $cg) /* @var $cg dictionary\models\DictCompetitiveGroup */ :?>
        <tr>
            <td><?= ++$key ?></td>
            <td><?= $cg->faculty->full_name ?></td>
            <td><?= $cg->specialty->code." ".$cg->specialty->name ?></td>
            <td><?= DictCompetitiveGroupHelper::eduLevelName($cg->edu_level) ?></td>
            <td><?= DictCompetitiveGroupHelper::specialRightName($cg->special_right_id) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
