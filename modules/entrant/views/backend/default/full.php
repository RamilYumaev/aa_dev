<?php
/* @var $this yii\web\View */

/* @var $profile olympic\models\auth\Profiles */

use modules\entrant\helpers\CseViSelectHelper;
use yii\helpers\Html;

$this->title = $profile->getFio() . '. Персональная карточка поступающего';
$this->params['breadcrumbs'][] = ['label' => 'Абитуриенты', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = $profile->anketa;
$userId = $profile->user_id;
?>
<?= Html::a("Экспорт в АИС", ['communication/export-data', 'user' => $userId], ['data-method' => 'post', 'class' => 'btn btn-success']) ?>

<?= Html::a("Data Json", ['default/data-json', 'user' => $userId], ['class' => 'btn btn-danger']) ?>
<?= Html::a("Файлы", ['default/files', 'user' => $userId], ['class' => 'btn btn-danger']) ?>
<?= Html::a("Редактировать данные", \Yii::$app->params['staticHostInfo'] . '/switch-user/by-user-id?id=' . $userId,
    ['class' => 'btn btn-info', 'target' => '_blank']); ?>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\profile\ProfileWidget::widget(['userId' => $userId, 'view' => 'index-backend']); ?>
</div>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\anketa\AnketaWidget::widget(['userId' => $userId]); ?>
</div>
<?php if (!$anketa->isRussia()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\profile\FioLatinWidget::widget(['userId' => $userId, 'view' => 'fio-backend']); ?>
    </div>
<?php endif; ?>
<?php if (!$anketa->isNoRequired()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\address\AddressWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
    </div>
<?php endif; ?>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['userId' => $userId, 'view' => "detail-backend"]); ?>
</div>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\passport\PassportDataWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
</div>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\education\DocumentEducationWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
</div>
<?php if ($anketa->isAgreement()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
    </div>
<?php endif; ?>
<?php if ($anketa->isPatriot()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['userId' => $userId, 'view' => "other-backend"]); ?>
    </div>
<?php endif; ?>
<?php if ($anketa->isExemption()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['userId' => $userId, 'type' => 'exemption', 'view' => "other-backend"]); ?>
    </div>
<?php endif; ?>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\language\LanguageWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
</div>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\cg\CgWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
</div>

<?= \modules\entrant\widgets\cse\CseSubjectMaxResultWidget::widget(['userId' => $userId, 'view' => "max-backend"]); ?>

<?php if (\dictionary\helpers\DictCompetitiveGroupHelper::bachelorExistsUser($userId)
    && !\modules\entrant\helpers\CseSubjectHelper::cseSubjectExists($userId)): ?>
    <div class="mt-20">
        <?= \modules\entrant\widgets\examinations\ExaminationsIndexWidget::widget(['userId' => $userId, 'view' => "index-data-backend"]); ?>
    </div>
<?php endif; ?>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\information\AdditionalInformationWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
</div>
<?php if (!$anketa->isNoRequired()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\individual\IndividualAchievementsWidget::widget(['userId' => $userId, 'view' => 'index-backend']) ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\PreemptiveRightIndexWidget::widget(['userId' => $userId, 'view' => 'preemptive-right-backend-index']); ?>
    </div>
<?php endif; ?>
<div class="mt-20 table-responsive">
    <?= \modules\entrant\widgets\other\DocumentOtherWidget::widget(['userId' => $userId, 'view' => "index-backend"]); ?>
</div>