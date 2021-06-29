<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\DocumentEducationHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementConsent modules\entrant\models\StatementConsentCg */

$user = $statementConsent->statementCg->statement->user_id;
$profile = ProfileHelper::dataArray($user);
$name = \common\auth\helpers\DeclinationFioHelper::userDeclination($user);
$cg = \dictionary\helpers\DictCompetitiveGroupHelper::dataArray($statementConsent->statementCg->cg_id);
$passport = \modules\entrant\helpers\PassportDataHelper::dataArray($user);
$education = DocumentEducationHelper::dataArray($user)

?>

<?= $this->render("_header", ['profile' => $profile, 'user_id' => $user, 'name' => $name, 'cg' => $cg]) ?>
<?= $this->render("_body", ['statementConsent' => $statementConsent,
    'name' => $name, 'cg' => $cg, 'passport' => $passport, 'profile' => $profile, 'education'=>$education]) ?>
