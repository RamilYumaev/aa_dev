<?php
/* @var $this yii\web\View */

use olympic\helpers\auth\ProfileHelper;
use modules\entrant\helpers\PassportDataHelper;

/* @var $statementPd modules\transfer\models\StatementConsentPersonalData */
$profile = ProfileHelper::dataArray($statementPd->user_id);
$passport = PassportDataHelper::dataArray($statementPd->user_id);
?>
<?php if (!$statementPd->countFilesINSend()): ?>
    <?php if ($passport['age'] > 17): ?>
        <?= $this->render("_main_adult", ['profile' => $profile, 'statementPd' => $statementPd]) ?>
    <?php else: ?>
        <?= $this->render("_main_minor", ['profile' => $profile, 'statementPd' => $statementPd]) ?>
    <?php endif; ?>
<?php else: ?>
    <?php if ($statementPd->count_pages == 4): ?>
        <?= $this->render("_main_adult", ['profile' => $profile, 'statementPd' => $statementPd]) ?>
    <?php else: ?>
        <?= $this->render("_main_minor", ['profile' => $profile, 'statementPd' => $statementPd]) ?>
    <?php endif; ?>
<?php endif; ?>
