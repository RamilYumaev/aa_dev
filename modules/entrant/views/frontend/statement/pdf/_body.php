<?php
/* @var $this yii\web\View */
/* @var $gender string */
/* @var $anketa array */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\FileCgHelper;

/* @var $statement modules\entrant\models\Statement */

?>

<div class="mt-25">
    <p align="center"><strong>ЗАЯВЛЕНИЕ №</strong><?= $statement->numberStatement ?></p>
    <p align="justify"><strong>Прошу допустить меня к участию в конкурсе на следующие основные образовательные программы
            <?= DictCompetitiveGroupHelper::getEduLevelsGenitiveNameOne($statement->edu_level) ." ". $statement->faculty->genitive_name?>:</strong></p>
    <div class="row ">
    <?php if($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO && !$statement->special_right): ?>
            <?= $this->render('_level_edu/spo',['statement' => $statement, 'gender' => $gender,  'anketa'=>$anketa]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER && !$statement->special_right): ?>
             <?= $this->render('_level_edu/mag',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && !$statement->special_right): ?>
             <?= $this->render('_level_edu/bac',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $statement->special_right==DictCompetitiveGroupHelper::SPECIAL_RIGHT):?>
        <?= $this->render('_level_edu/bac_ex',['statement' => $statement, 'gender' => $gender, 'anketa'=> $anketa ]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $statement->special_right==DictCompetitiveGroupHelper::SPECIAL_QUOTA):?>
             <?= $this->render('_level_edu/bac_ex_s',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa ]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $statement->special_right==DictCompetitiveGroupHelper::TARGET_PLACE): ?>
             <?= $this->render('_level_edu/bac_ag',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
        <?php else: ?>
            <?= $this->render('_level_edu/asp',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
    <?php endif; ?>
</div>

</div>


