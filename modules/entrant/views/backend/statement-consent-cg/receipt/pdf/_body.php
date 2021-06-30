<?php
/* @var $this yii\web\View */
/* @var $gender string */

/* @var $profile array */

/* @var $passport array */

/* @var $education array */

/* @var $name \common\auth\models\DeclinationFio */

/* @var $cg array */


/* @var $statementConsent modules\entrant\models\StatementConsentCg */
use modules\entrant\helpers\DocumentEducationHelper;
use modules\entrant\helpers\DateFormatHelper;
$education = \modules\entrant\models\DocumentEducation::findOne(['user_id' => $statementConsent->statementCg->statement->user_id]);

$nameFull = $name->genitive ?? $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic'];

?>
<div class="fs-15" style="margin-top: 80px">
    <p align="center"><strong>РАСПИСКА № <?= $statementConsent->statementCg->statement->user_id?></strong></p>

<p align="justify" class="lh-1-5">
О приеме оригинала документа об образовании <?=$nameFull;?>: <?=$education->typeName.' '. $education->series ." ".$education->number?>, выданный <?=DateFormatHelper::formatView($education->date).' '.$education->school->name." (".$education->school->countryRegion.")"?>
            </p>



    
    <table width="100%" class="mt-50 fs-15">
        <tr>
            
            <td width="15%"><?= date("d.m.Y") ?> г.</td>
            <td class="bb" width="25%"></td>
            <td class="bb" width="35%"></td>

        </tr>
        <tr>
            <td width="25%"></td>
            <td width="35%" class="v-align-top text-center">(подпись сотрудника ОК)</td>
            <td width="35%" class="v-align-top text-center">(ФИО сотрудника ОК)</td>
            <td width="10%"></td>

        </tr>
    </table>
</div>

