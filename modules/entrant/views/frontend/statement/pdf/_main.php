<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statement modules\entrant\models\Statement */


$profile = ProfileHelper::dataArray($statement->user_id);
$anketa =  AnketaHelper::dataArray($statement->user_id);

?>


 <?= $this->render($anketa["addressNoRequired"] ? "_header_no_address":"_header",['profile' => $profile,
    'anketa'=>$anketa,'user_id' => $statement->user_id]) ?>
 <?= $this->render("_body",['statement' => $statement, 'anketa'=>$anketa, 'gender' => $profile["gender"] ]) ?>
