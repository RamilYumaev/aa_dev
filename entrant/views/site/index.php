<?php

/* @var $this yii\web\View */

use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\DataExportHelper;

/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $jobEntrant \modules\dictionary\models\JobEntrant */
$text = " ";
if(!Yii::$app->user->isGuest ) {
    $jobEntrant = Yii::$app->user->identity->jobEntrant();
    $text = $jobEntrant ? $jobEntrant->fullNameJobEntrant : "";
}
$this->title= "Главная. ".$text;
var_dump((new \api\client\Client())->postData('entrant-export',  DataExportHelper::cseIncomingId()));
?>
<?php if(!Yii::$app->user->identity->isActive()): ?>
    <div><?= Yii::$app->session->setFlash('warning',
        'Необходимо ' .
        \yii\helpers\Html::a('подтвердить почту', '/sign-up/user-edit')); ?></div>
    <?php endif;?>
<?php if($jobEntrant && $jobEntrant->category_id == 0): ?>
    <div><?= Yii::$app->session->setFlash('info',
            'Необходимо заполнить/отредактировать дополнительную информацию ' .
            \yii\helpers\Html::a('здесь', '/data-entrant/volunteering')); ?></div>
<?php endif;?>
<?php if($jobEntrant && !$jobEntrant->isStatusDraft()): ?>
  <?php if($jobEntrant->isCategoryCOZ()):?>
    <?= $this->render('_coz',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryFOK()):?>
        <?= $this->render('_coz_fok',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryTarget()): ?>
        <?= $this->render('_bb',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_agreement',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryMPGU()): ?>
        <?= $this->render('_mpgu',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryUMS()): ?>
        <?= $this->render('_coz',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isAgreement()): ?>
        <?= $this->render('_contract',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_receipt',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isCategoryGraduate()): ?>
        <?= $this->render('_coz_fok',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_contract',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_receipt',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if(in_array($jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())): ?>
        <?= $this->render('_coz_fok',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_contract',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_receipt',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
    <?php if($jobEntrant->isTPGU()):?>
        <?= $this->render('_coz',['jobEntrant' => $jobEntrant])?>
        <?= $this->render('_fok',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
<?php endif; ?>
