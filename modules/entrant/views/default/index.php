<?php
/* @var $this yii\web\View */

$this->title = 'Заполнение персональной карточки поступающего';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
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
        <?= \modules\entrant\widgets\cg\CgWidget::widget(); ?>
    </div>
    <div class="mt-20">
        <?= \modules\entrant\widgets\cse\CseSubjectMaxResultWidget::widget(); ?>
    </div>

    <?php if(\dictionary\helpers\DictCompetitiveGroupHelper::bachelorExistsUser(Yii::$app->user->identity->getId())
        && !\modules\entrant\helpers\CseSubjectHelper::cseSubjectExists(Yii::$app->user->identity->getId())): ?>
    <div class="mt-20">
        <?= \modules\entrant\widgets\examinations\ExaminationsIndexWidget::widget();?>
    </div>
    <?php endif; ?>
    <div class="mt-20">
        <?= \modules\entrant\widgets\information\AdditionalInformationWidget::widget(); ?>
    </div>
    <?php if(\modules\entrant\helpers\PostDocumentHelper::isCorrectBlocks()) :?>
        <?= \modules\entrant\widgets\submitted\SubmittedDocumentWidget::widget() ?>
    <?php endif; ?>
</div>