<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;
use \common\auth\helpers\DeclinationFioHelper;

/* @var $statementRejection modules\entrant\models\StatementRejection */


$profile = ProfileHelper::dataArray($statementRejection->statement->user_id);
$passport = PassportDataHelper::dataArray($statementRejection->statement->user_id);
$name = DeclinationFioHelper::userDeclination($statementRejection->statement->user_id);


?>
<table class="fs-15">
    <tr>
        <td width="62%"></td>
        <td>
            Председателю Приемной<br/>
            комиссии МПГУ,<br/>
            ректору МПГУ<br/>
            А.В. Лубкову<br/>
            От: <?= $name->genitive ?? $profile['last_name'] . " " . $profile['first_name'] . " " . $profile['patronymic'] ?>
            <br/>
            тел.: <?= $profile['phone'] ?>
        </td>
    </tr>
</table>


<div class="mt-200 fs-15">
    <p align="center"><strong>Заявление</strong></p>
    <p align="justify" class="lh-1-5">
        Я, <?= $name->nominative ?? $profile['last_name'] . " " . $profile['first_name'] . " " . $profile['patronymic'] ?>
        <?= $passport['date_of_birth'] ?> года рождения, отзываю свое заявление об участии в конкурсе №
        <?= $statementRejection->statement->numberStatement ?> в отношении образовательных программ:
    <ol>
        <?php foreach ($statementRejection->statement->statementCg as $statementCg) : ?>
            <li><?= $statementRejection->statement->speciality->codeWithName ?>,
            <?= $statementRejection->statement->eduLevel ?>,
            <?= $statementRejection->statement->specialRight ?>,
            <?= $statementCg->cg->fullName ?>.</li>
        <?php endforeach; ?>
    </ol>
    </p>

<table width="100%" class="mt-50 ml-30">
        <tr>
            <td class="text-right fs-15"><?=\date("d.m.Y")?></td>
            <td width="45%" class="bb"></td>
            <td class="fs-15"><?=$name->nominative ?? $profile['last_name'] . " " . $profile['first_name'] . " " . $profile['patronymic']?></td>
        </tr>
        <tr>
            <td></td>
            <td class="fs-10 v-align-top text-center">(подпись поступающего)</td>
            <td></td>
        </tr>
    </table>
    </p>
</div>

