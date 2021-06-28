<?php
/* @var $this yii\web\View */

use common\auth\helpers\DeclinationFioHelper;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementRejection modules\entrant\models\StatementRejectionCg */


$profile = ProfileHelper::dataArray($statementRejection->statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($statementRejection->statementCg->statement->user_id);
$name = DeclinationFioHelper::userDeclination($statementRejection->statementCg->statement->user_id);


?>

<table class="fs-15">
    <tr> 
    <td width="10%"></td>
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
        <?= $statementRejection->statementCg->statement->numberStatement ?> в отношении образовательной программы:
    <ol><li>
        <?= $statementRejection->statementCg->statement->speciality->codeWithName ?>,
        <?= $statementRejection->statementCg->statement->eduLevel ?>,
        <?= $statementRejection->statementCg->statement->specialRight ?>,
        <?= $statementRejection->statementCg->cg->fullName ?>.
        </li>
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
</div>