<?php
/* @var $this yii\web\View */

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Загрузка документов';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = Yii::$app->user->identity->anketa();
$userId =  Yii::$app->user->identity->getId();
?>

<div class="container">
    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
                "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
    <h1 align="center"><?= $this->title ?></h1>
    <div class="row">
        <div class="col-md-12">
            <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['view' => 'file', 'userId' => $userId]); ?>

            <?= \modules\entrant\widgets\education\DocumentEducationFileWidget::widget(['userId' => $userId]); ?>

            <?php if ($anketa->isAgreement()): ?>
                <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['view' => 'file', 'userId' => $userId]); ?>
            <?php endif; ?>

            <?php if (!$anketa->isNoRequired()): ?>
                <?= \modules\entrant\widgets\address\AddressFileWidget::widget(['userId' => $userId]); ?>
            <?php endif; ?>

            <?= \modules\entrant\widgets\other\DocumentOtherFileWidget::widget(['userId' => $userId]); ?>

            <?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget(['userId' => $userId,
                'formCategory' => DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1]); ?>

            <?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget(['userId' => $userId,
                'formCategory' =>DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2]); ?>

            <?= \modules\entrant\widgets\statement\StatementIaWidget::widget(['userId' => $userId]); ?>

            <?= \modules\entrant\widgets\statement\StatementPersonalDataWidget::widget(['userId' => $userId]); ?>

            <?= \modules\entrant\widgets\statement\StatementCgConsentWidget::widget(['userId' => $userId]); ?>

        </div>
    </div>
    <div class="row mb-30">
        <div class="col-md-offset-4 col-md-4">
            <?= Html::a("Отправить в приемную комиссию", ['post-document/send'], ["class" => "btn btn-success btn-lg", 'data'=> ['method' => 'post']]) ?>
        </div>
    </div>
</div>
</div>
