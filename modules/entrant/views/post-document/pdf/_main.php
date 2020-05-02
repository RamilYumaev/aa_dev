<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $faculty integer */
/* @var $speciality integer */
/* @var $edu_level integer */
/* @var $special_right_id integer|null */
/* @var $user_id integer */


$profile = ProfileHelper::dataArray($user_id);

?>

<div class="container">
 <?= $this->render("_header",['profile' => $profile, 'user_id' => $user_id]) ?>
 <?= $this->render("_body",['edu_level' => $edu_level, 'faculty'=>$faculty,
     'speciality'=> $speciality, 'special_right_id' =>$special_right_id, 'user_id' => $user_id]) ?>
</div>