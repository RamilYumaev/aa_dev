<?php
/* @var $this yii\web\View */
/* @var $gender string */

/* @var $profile array */

/* @var $passport array */

/* @var $education array */

/* @var $name \common\auth\models\DeclinationFio */

/* @var $cg array */
/* @var $cg \dictionary\models\DictCompetitiveGroup */


/* @var $statementRejection modules\entrant\models\StatementRejectionRecord */
$nameFull = $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic'];

use dictionary\helpers\DictCompetitiveGroupHelper; ?>

<div class="mt-200 fs-15">
    <p align="center"><strong>Заявление</strong></p>
    <p align="justify" class="lh-1-5">
        Я, <?= $name->nominative ?? $profile['last_name'] . " " . $profile['first_name'] . " " . $profile['patronymic'] ?>,
        прошу исключить меня из приказа МПГУ от <?=$statementRejection->order_date ?> № <?= $statementRejection->order_name ?>
        о зачислении в число студентов 1 курса по образовательной программе <?= $cg->edu_level== DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO ? "среднего профессионального образования" : "высшего образования"?> – программе <?= DictCompetitiveGroupHelper::eduLevelGenitive()[$cg->edu_level] ?> –
        на <?= DictCompetitiveGroupHelper::getEduFormsAccusative()[$cg->education_form_id] ?> форму обучения на место, финансируемое из федерального бюджета, с 1 сент. 2019 г.
        в
        <?php if($cg->edu_level== DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO ):?>
            <?= $cg->faculty->full_name ?> по направлению подготовки: <?= $cg->specialty->codeWithName?> в связи с желанием быть зачисленным в другую образовательную организацию.
        <?php else:?>
            <?= $cg->faculty->full_name ?>: <?= $cg->specialty->codeWithName?><?= $cg->specialisationName ? ": ". $cg->specialisationName. "." : "."?>
        <?php endif;?>
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
