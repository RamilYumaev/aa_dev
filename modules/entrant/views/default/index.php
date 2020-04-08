<?php
/* @var $this yii\web\View */

$this->title = 'Онлайн-регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container m-20">
    <div class="mt-20">
        <?= \modules\entrant\widgets\profile\ProfileWidget::widget(); ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\address\AddressWidget::widget(); ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\passport\PassportDataWidget::widget(); ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\education\DocumentEducationWidget::widget(); ?>
    </div>
    <?php if(\Yii::$app->user->identity->anketa()->isAgreement()): ?>
        <div class="mt-20">
        <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(); ?>
        </div>
    <?php endif; ?>
    <?php if(\Yii::$app->user->identity->anketa()->isPatriot()): ?>
        <div class="mt-20">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(); ?>
        </div>
    <?php endif; ?>
    <?php if(\Yii::$app->user->identity->anketa()->isExemption()): ?>
        <div class="mt-20">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['type'=> 'exemption']); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20">
        <?= \modules\entrant\widgets\language\LanguageWidget::widget(); ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\other\DocumentOtherWidget::widget(); ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\individual\IndividualAchievementsWidget::widget() ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\cse\CseSubjectMaxResultWidget::widget(); ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\cg\CgWidget::widget(); ?>
    </div>
    <?php if(\modules\entrant\helpers\PostDocumentHelper::isCorrectBlocks()) :?>
        <?= \modules\entrant\widgets\submitted\SubmittedDocumentWidget::widget() ?>
    <?php endif; ?>
</div>