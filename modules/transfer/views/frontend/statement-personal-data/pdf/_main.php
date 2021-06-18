<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;
use modules\entrant\helpers\PassportDataHelper;

/* @var $statementPd modules\entrant\models\StatementConsentPersonalData */
/* @var $anketa modules\entrant\models\Anketa */


$profile = ProfileHelper::dataArray($statementPd->user_id);
$passport = PassportDataHelper::dataArray($statementPd->user_id);

?>



