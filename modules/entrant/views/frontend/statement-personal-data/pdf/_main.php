<?php
/* @var $this yii\web\View */
use olympic\helpers\auth\ProfileHelper;
use modules\entrant\helpers\PassportDataHelper;
/* @var $statementPd modules\entrant\models\StatementConsentPersonalData */
/* @var $anketa modules\entrant\models\Anketa */
$profile = ProfileHelper::dataArray($statementPd->user_id);
$userAnketa = $statementPd->anketa;
$passport = PassportDataHelper::dataArray($statementPd->user_id);
?>
<?php if (!$statementPd->countFilesINSend()): ?>
    <?php if ($passport['age'] > 17): ?>
        <?= $this->render("_main_adult", ['profile' => $profile, 'statementPd' => $statementPd, 'anketa' => $userAnketa]) ?>
    <?php else: ?>
        <?= $this->render("_main_minor", ['profile' => $profile, 'statementPd' => $statementPd, 'anketa' => $userAnketa]) ?>
    <?php endif; ?>
<?php else: ?>
    <?php if ($statementPd->count_pages == 4): ?>
        <?= $this->render("_main_adult", ['profile' => $profile, 'statementPd' => $statementPd, 'anketa' => $userAnketa]) ?>
    <?php else: ?>
        <?= $this->render("_main_minor", ['profile' => $profile, 'statementPd' => $statementPd, 'anketa' => $userAnketa]) ?>
    <?php endif; ?>
<?php endif; ?>
