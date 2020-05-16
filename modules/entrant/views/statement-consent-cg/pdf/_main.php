<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementConsent modules\entrant\models\StatementConsentCg */

$user = $statementConsent->statementCg->statement->user_id;
$profile = ProfileHelper::dataArray($user);

?>
 <?= $this->render("_header",['profile' => $profile, 'user_id' => $user]) ?>
 <?= $this->render("_body",['statementConsent' => $statementConsent]) ?>
