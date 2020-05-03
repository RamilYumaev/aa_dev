<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statement modules\entrant\models\Statement */


$profile = ProfileHelper::dataArray($statement->user_id);

?>

<div class="container">
 <?= $this->render("_header",['profile' => $profile, 'user_id' => $statement->user_id]) ?>
 <?= $this->render("_body",['statement' => $statement]) ?>
</div>