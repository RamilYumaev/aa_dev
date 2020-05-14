<?php
/* @var $this yii\web\View */
/* @var $gender string */
/* @var $anketa array */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\IndividualAchievementsHelper;

/* @var $statementIA modules\entrant\models\StatementIndividualAchievements */
/* @var $item modules\entrant\models\UserIndividualAchievements */

?>
<div class="mt-25">
    <p align="center"><strong>ЗАЯВЛЕНИЕ <?= $statementIA->numberStatement ?> </strong></p>
    <p align="justify"><strong>Прошу ...
            <?= DictCompetitiveGroupHelper::getEduLevelsGenitiveNameOne($statementIA->edu_level) ?>:</strong></p>
    <div class="row ">
        <table>
            <tr>
                <th>№</th>
                <th>Наименовние</th>
                <th>Отметка</th>
            </tr>
            <?php foreach ($statementIA->statementIa as $key => $item ) : ?>
            <tr>
                <td><?= ++$key ?></td>
                <td><?= $item->dictIndividualAchievement->name ?></td>
                <td></td>
            </tr>
            <?php endforeach;?>
        </table>
</div>

</div>


