<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\DocumentEducationHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementRejection modules\entrant\models\StatementRejectionRecord */

$user = $statementRejection->user_id;
$profile = ProfileHelper::dataArray($user);
$name = \common\auth\helpers\DeclinationFioHelper::userDeclination($user);
$cg = $statementRejection->cg;
$passport = \modules\entrant\helpers\PassportDataHelper::dataArray($user);
$education = DocumentEducationHelper::dataArray($user)

?>

<?= $this->render("_header", ['profile' => $profile, 'user_id' => $user, 'name' => $name, 'cg' => $cg]) ?>
<?= $this->render("_body", ['statementRejection' => $statementRejection,
    'name' => $name, 'cg' => $cg, 'passport' => $passport, 'profile' => $profile, 'education'=>$education]) ?>
