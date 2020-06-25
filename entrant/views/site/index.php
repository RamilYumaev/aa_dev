<?php

/* @var $this yii\web\View */

use modules\dictionary\helpers\JobEntrantHelper;

/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $jobEntrant \modules\dictionary\models\JobEntrant */
$text = " ";


if(!Yii::$app->user->isGuest ) {
    $jobEntrant = Yii::$app->user->identity->jobEntrant();
    $text = $jobEntrant ? $jobEntrant->fullNameJobEntrant : "";
}
$this->title= "Главная. ".$text;
?>
<?php if($jobEntrant): ?>
  <?php if($jobEntrant->isCategoryCOZ()):?>
    <?= $this->render('_coz',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryFOK()):?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryTarget()): ?>
        <?= $this->render('_coz',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_agreement',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryMPGU()): ?>
        <?= $this->render('_mpgu',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryUMS()): ?>
        <?= $this->render('_coz',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryGraduate()): ?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if(in_array($jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())): ?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
<?php endif; ?>
