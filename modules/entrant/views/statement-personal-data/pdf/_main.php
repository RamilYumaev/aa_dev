<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementPd modules\entrant\models\StatementConsentPersonalData */
/* @var $anketa modules\entrant\models\Anketa */


$profile = ProfileHelper::dataArray($statementPd->user_id);
$userAnketa = $anketa;

?>


<?= $this->render("_header", ['profile' => $profile, 'user_id' => $statementPd->user_id, 'anketa' => $userAnketa]) ?>
<?= $this->render("_body", ['statementPd' => $statementPd]) ?>
