<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\DocumentEducationHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statement \modules\transfer\models\StatementTransfer */

$user = $statement->user_id;
$profile = ProfileHelper::dataArray($user);
$name = \common\auth\helpers\DeclinationFioHelper::userDeclination($user);
$passport = \modules\entrant\helpers\PassportDataHelper::dataArray($user);

?>

<?= $this->render("_header", ['profile' => $profile, 'user_id' => $user, 'name' => $name]) ?>
<?= $this->render("_body", ['statement' => $statement, 'name' => $name, 'passport' => $passport, 'profile' => $profile]) ?>
<?= $this->render("_footer", ['statement' => $statement]) ?>

