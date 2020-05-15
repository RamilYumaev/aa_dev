<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementPd modules\entrant\models\StatementConsentPersonalData */


$profile = ProfileHelper::dataArray($statementPd->user_id);

?>


 <?= $this->render("_header",['profile' => $profile, 'user_id' => $statementPd->user_id]) ?>
 <?= $this->render("_body",['statementPd' => $statementPd]) ?>
