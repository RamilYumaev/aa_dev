<?php
/* @var $this yii\web\View */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\FileCgHelper;

/* @var $statement modules\entrant\models\Statement */

$userCg = FileCgHelper::cgUser($statement->user_id, $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg());
?>
    <h2>ЗАЯВЛЕНИЕ №<?= $statement->numberStatement ?></h2>
    <div class="row ">
    <?php if($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO && !$statement->special_right): ?>
            <?= $this->render('_level_edu/spo',['userCg'=> $userCg]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER && !$statement->special_right): ?>
             <?= $this->render('_level_edu/mag',['userCg'=> $userCg]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && !$statement->special_right): ?>
             <?= $this->render('_level_edu/bac',['userCg'=> $userCg]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $statement->special_right==DictCompetitiveGroupHelper::SPECIAL_RIGHT):?>
             <?= $this->render('_level_edu/bac_ex',['userCg'=> $userCg]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $statement->special_right==DictCompetitiveGroupHelper::TARGET_PLACE): ?>
             <?= $this->render('_level_edu/bac_ag',['userCg'=> $userCg]) ?>
        <?php else: ?>
            <?= $this->render('_level_edu/asp',['userCg'=> $userCg]) ?>
    <?php endif; ?>
</div>


