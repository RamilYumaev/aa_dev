<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementIA modules\entrant\models\StatementIndividualAchievements */


$profile = ProfileHelper::dataArray($statementIA->user_id);

?>


 <?= $this->render("_header",['profile' => $profile, 'user_id' => $statementIA->user_id]) ?>
 <?= $this->render("_body",['statementIA' => $statementIA]) ?>
