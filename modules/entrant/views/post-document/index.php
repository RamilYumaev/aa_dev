<?php
/* @var $this yii\web\View */

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Загрузка сканированных копий документов';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = Yii::$app->user->identity->anketa();
?>
<div class="container m-20">

<?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget();?>

<?= \modules\entrant\widgets\statement\StatementIaWidget::widget(['userId'=> Yii::$app->user->identity->getId()]);?>

<?= \modules\entrant\widgets\education\DocumentEducationFileWidget::widget();?>

<?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['view' => 'file']);?>

<?php if($anketa->isAgreement()): ?>
    <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['view'=>'file']); ?>
<?php endif; ?>

<?php if(!$anketa->isRussia()): ?>
<?= \modules\entrant\widgets\address\AddressFileWidget::widget();?>
<?php endif; ?>

<?= \modules\entrant\widgets\other\DocumentOtherFileWidget::widget();?>

</div>
