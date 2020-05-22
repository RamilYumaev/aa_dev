<?php
/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles*/

use yii\helpers\Html;

$this->title = $profile->getFio().' Персональная карточка поступающего';
$this->params['breadcrumbs'][] = ['label' => 'Абитуриенты', 'url' => ['data-entrant/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = $profile->anketa;
$userId = $profile->user_id;
?>
<?= Html::a("Экспорт в АИС", ['communication/export-data','user'=> $userId], ['data-method'=>'post', 'class' => 'btn btn-success']) ?>
<?= Html::a("Data Json", ['default/data-json', 'user'=> $userId], [ 'class' => 'btn btn-danger']) ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\profile\ProfileWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (!$anketa->isRussia()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\profile\FioLatinWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <?php if (!$anketa->isNoRequired()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\address\AddressWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['userId' => $userId,'view' => "detail"]); ?>
    </div>
    <div class="mt-20 table-responsive">
       <?= \modules\entrant\widgets\passport\PassportDataWidget::widget(['userId' => $userId]); ?>
    </div>

    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\education\DocumentEducationWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if ($anketa->isAgreement()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['userId' => $userId, 'view' => 'index']); ?>
        </div>
    <?php endif; ?>
    <?php if ($anketa->isPatriot()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <?php if ($anketa->isExemption()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['userId' => $userId, 'type' => 'exemption']); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\language\LanguageWidget::widget(['userId' => $userId]); ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\cg\CgWidget::widget(['userId' => $userId]); ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\cse\CseSubjectMaxResultWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (\dictionary\helpers\DictCompetitiveGroupHelper::bachelorExistsUser($userId)
        && !\modules\entrant\helpers\CseSubjectHelper::cseSubjectExists($userId)): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\examinations\ExaminationsIndexWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\information\AdditionalInformationWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (!$anketa->isNoRequired()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\individual\IndividualAchievementsWidget::widget(['userId' => $userId]) ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\PreemptiveRightIndexWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\DocumentOtherWidget::widget(['userId' => $userId]); ?>
    </div>