<?php
/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles*/
use yii\helpers\Html;
$this->title = 'Файлы';
$this->params['breadcrumbs'][] = ['label' => 'Абитуриенты', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => $profile->getFio(), 'url' => ['default/full', 'user' => $profile->user_id]];
$this->params['breadcrumbs'][] = $this->title;

$anketa = $profile->anketa;
$userId = $profile->user_id;
?>
<div class="row">
        <div class="col-md-12">
            <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['view' => 'file-backend', 'userId' => $userId]); ?>

            <?= \modules\entrant\widgets\education\DocumentEducationFileWidget::widget(['userId' => $userId]); ?>

            <?php if ($anketa->isAgreement()): ?>
                <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['view' => 'file', 'userId' => $userId]); ?>
            <?php endif; ?>

            <?php if (!$anketa->isNoRequired()): ?>
                <?= \modules\entrant\widgets\address\AddressFileWidget::widget(['userId' => $userId]); ?>
            <?php endif; ?>

            <?= \modules\entrant\widgets\other\DocumentOtherFileWidget::widget(['userId' => $userId]); ?>

            <?= \modules\entrant\widgets\statement\StatementPersonalDataWidget::widget(['userId' => $userId]); ?>
        </div>
    </div>
