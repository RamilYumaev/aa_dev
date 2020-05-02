<?php
/* @var $this yii\web\View */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\FileCgHelper;

/* @var $faculty integer */
/* @var $speciality integer */
/* @var $edu_level integer */
/* @var $special_right_id integer|null */
/* @var $user_id integer */

$userCg = FileCgHelper::cgUser($user_id, $faculty, $speciality);
?>
<div class="row ">
    <?php if($edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO && !$special_right_id): ?>
            <?= $this->render('_level_edu/spo',['userCg'=> $userCg]) ?>
        <?php elseif($edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER && !$special_right_id): ?>
             <?= $this->render('_level_edu/mag',['userCg'=> $userCg]) ?>
        <?php elseif($edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && !$special_right_id): ?>
             <?= $this->render('_level_edu/bac',['userCg'=> $userCg]) ?>
        <?php elseif($edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $special_right_id==DictCompetitiveGroupHelper::SPECIAL_RIGHT):?>
             <?= $this->render('_level_edu/bac_ex',['userCg'=> $userCg]) ?>
        <?php elseif($edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $special_right_id==DictCompetitiveGroupHelper::TARGET_PLACE): ?>
             <?= $this->render('_level_edu/bac_ag',['userCg'=> $userCg]) ?>
        <?php else: ?>
            <?= $this->render('_level_edu/asp',['userCg'=> $userCg]) ?>
    <?php endif; ?>
</div>

