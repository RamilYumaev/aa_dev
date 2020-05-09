<?php
/* @var $this yii\web\View */
/* @var $gender string */
/* @var $anketa array */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\FileCgHelper;

/* @var $statement modules\entrant\models\Statement */

?>

<div style="font-family: 'Times New Roman'; margin-top: 25px; font-size: 9px">
    <h6 align="center"><strong>ЗАЯВЛЕНИЕ №</strong><?= $statement->numberStatement ?></h6>
    <p align="justify"><strong>Прошу допустить меня к участию в конкурсе на следующие основные образовательные программы
            бакалавриата Института филологии:</strong></p>
    <div class="row ">
    <?php if($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO && !$statement->special_right): ?>
            <?= $this->render('_level_edu/spo',['statement' => $statement, 'gender' => $gender,  'anketa'=>$anketa]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER && !$statement->special_right): ?>
             <?= $this->render('_level_edu/mag',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && !$statement->special_right): ?>
             <?= $this->render('_level_edu/bac',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $statement->special_right==DictCompetitiveGroupHelper::SPECIAL_RIGHT):?>
             <?= $this->render('_level_edu/bac_ex',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa ]) ?>
        <?php elseif($statement->edu_level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $statement->special_right==DictCompetitiveGroupHelper::TARGET_PLACE): ?>
             <?= $this->render('_level_edu/bac_ag',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
        <?php else: ?>
            <?= $this->render('_level_edu/asp',['statement' => $statement, 'gender' => $gender, 'anketa'=>$anketa]) ?>
    <?php endif; ?>
</div>

</div>


