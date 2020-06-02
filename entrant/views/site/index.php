<?php
use dictionary\helpers\DictSchoolsHelper;use modules\entrant\readRepositories\ProfileStatementReadRepository;
/* @var $this yii\web\View */

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
  <?php if($jobEntrant->isCategoryCOZ()): ?>
    <?= $this->render('_coz',['jobEntrant' => $jobEntrant])?>
    <?php endif; ?>
<?php endif; ?>
