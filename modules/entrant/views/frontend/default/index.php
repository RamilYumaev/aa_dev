<?php
/* @var $this yii\web\View */
/* @var $anketa \modules\entrant\models\Anketa */

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\AgreementHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use yii\helpers\Html;


$this->title = 'Персональная карточка поступающего';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = Yii::$app->user->identity->anketa();
$userId = Yii::$app->user->identity->getId();
?>


<?php
include 'navigation/index.html';
?>



<div class="container">
    <h1><?=$this->title?></h1>

    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]). " Уровни",
                "/abiturient/anketa/step2", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
    <?php if($adminUserId = \Yii::$app->session->get('user.idbeforeswitch')) : ?>
        <?= \modules\entrant\widgets\anketa\AnketaCiWidget::widget(['userId' => $userId])?>
    <?php endif;?>
    <div class="mt-20 table-responsive" id="profile">
        <?= \modules\entrant\widgets\profile\ProfileWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (!$anketa->isRussia()): ?>
        <div class="mt-20 table-responsive" id="latin">
            <?= \modules\entrant\widgets\profile\FioLatinWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <?php if (!$anketa->isNoRequired()): ?>
        <div class="mt-20 table-responsive" id="address">
            <?= \modules\entrant\widgets\address\AddressWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive" id="passport">
        <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['userId' => $userId,'view' => "detail"]); ?>
    </div>
    <?php if($anketa->isOrphan()):?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\passport\BirthDocumentWidget::widget(['userId' => $userId,'view' => "detail-birth-document"]); ?>
    </div>
    <?php endif;?>

    <?php if (DictCompetitiveGroupHelper::bachelorExistsUser($userId) && !$anketa->isTpgu()): ?>
    <div class="mt-20 table-responsive">
       <?= \modules\entrant\widgets\passport\PassportDataWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php endif; ?>

    <div class="mt-20 table-responsive" id="edu">
        <?= \modules\entrant\widgets\education\DocumentEducationWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (AgreementHelper::isExits($anketa->user_id)): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['userId' => $userId, 'view' => 'index']); ?>
        </div>
    <?php endif; ?>
    <?php if ($anketa->isPatriot()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <?php if (OtherDocumentHelper::isExitsExemption($anketa->user_id)): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['userId' => $userId, 'type' => 'exemption', 'exemption' => [1,2,3]]); ?>
        </div>
    <?php endif; ?>
    <?php if (OtherDocumentHelper::isExitsSpecialQuota($anketa->user_id)): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\ExemptionOrPatriotWidget::widget(['userId' => $userId, 'type' => 'exemption', 'exemption' => [4]]); ?>
        </div>
    <?php endif; ?>
    <?php if ($anketa->isWithOitCompetition()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\other\WithoutOtherWidget::widget(['userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive" id="lang">
        <?= \modules\entrant\widgets\language\LanguageWidget::widget(['userId' => $userId]); ?>
    </div>
    <div class="mt-20 table-responsive" id="comp">
        <?= \modules\entrant\widgets\cg\CgWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (\dictionary\helpers\DictCompetitiveGroupHelper::bachelorExistsUser($userId) && !$anketa->isTpgu()): ?>
        <div class="mt-20 table-responsive" id="vi">
            <?= \modules\entrant\widgets\discipline\UserDisciplineWidget::widget(['anketa' => $anketa, 'userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <?php if (\dictionary\helpers\DictCompetitiveGroupHelper::bachelorExistsUser($userId, true)
        && DictCompetitiveGroupHelper::groupByExamsForeign($userId)
        && !$anketa->isTpgu()): ?>
        <div class="mt-20 table-responsive" id="vi-foreign">
            <?= \modules\entrant\widgets\discipline\UserDisciplineWidget::widget(['anketa' => $anketa, 'userId' => $userId, 'foreignStatus' => true]); ?>
        </div>
    <?php endif; ?>
    <?php if (\dictionary\helpers\DictCompetitiveGroupHelper::bachelorExistsUser($userId) && $anketa->onlySpo() && !$anketa->isTpgu()): ?>
        <div class="mt-20 table-responsive" id="vi-spo">
            <?= \modules\entrant\widgets\discipline\UserDisciplineSpoWidget::widget(['anketa' => $anketa, 'userId' => $userId]); ?>
        </div>
    <?php endif; ?>
    <div class="mt-20 table-responsive" id="additional">
        <?= \modules\entrant\widgets\information\AdditionalInformationWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (!$anketa->isNoRequired() && !$anketa->isTpgu()): ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\individual\IndividualAchievementsWidget::widget(['userId' => $userId]) ?>
    </div>
    <?php if($anketa->isRussia()):?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\PreemptiveRightIndexWidget::widget(['userId' => $userId]); ?>
    </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\MedicineOtherWidget::widget(['userId' => $userId]); ?>
    </div>
    <div class="mt-20 table-responsive">
        <?= \modules\entrant\widgets\other\DocumentOtherWidget::widget(['userId' => $userId]); ?>
    </div>
    <?php if (\modules\entrant\helpers\PostDocumentHelper::isCorrectBlocks($userId)) : ?>
        <?= \modules\entrant\widgets\submitted\SubmittedDocumentWidget::widget(['userId' => $userId]) ?>
    <?php endif; ?>
</div>