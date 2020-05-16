<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Персональная карточка поступающего';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = Yii::$app->user->identity->anketa();
?>
<div class="container">
    <h1><?=$this->title?></h1>

    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
                "/abiturient/anketa/step2", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\profile\ProfileWidget::widget(); ?>
    </div>
    <?php if (!$anketa->isRussia()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\profile\FioLatinWidget::widget(); ?>
        </div>
    <?php endif; ?>
    <?php if (!$anketa->isNoRequired()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\address\AddressWidget::widget(); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['view' => "detail"]); ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\education\DocumentEducationWidget::widget(); ?>
    </div>
    <?php if ($anketa->isAgreement()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['view' => 'index']); ?>
        </div>
    <?php endif; ?>
    <?php if ($anketa->isPatriot()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(); ?>
        </div>
    <?php endif; ?>
    <?php if ($anketa->isExemption()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['type' => 'exemption']); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\language\LanguageWidget::widget(); ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\cg\CgWidget::widget(); ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\cse\CseSubjectMaxResultWidget::widget(); ?>
    </div>
    <?php if (\dictionary\helpers\DictCompetitiveGroupHelper::bachelorExistsUser(Yii::$app->user->identity->getId())
        && !\modules\entrant\helpers\CseSubjectHelper::cseSubjectExists(Yii::$app->user->identity->getId())): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\examinations\ExaminationsIndexWidget::widget(); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\information\AdditionalInformationWidget::widget(); ?>
    </div>
    <?php if (!$anketa->isNoRequired()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\individual\IndividualAchievementsWidget::widget() ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\PreemptiveRightIndexWidget::widget(); ?>
    </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\DocumentOtherWidget::widget(); ?>
    </div>
    <?php if (\modules\entrant\helpers\PostDocumentHelper::isCorrectBlocks()) : ?>
        <?= \modules\entrant\widgets\submitted\SubmittedDocumentWidget::widget() ?>
    <?php endif; ?>
</div>