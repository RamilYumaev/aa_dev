<?php
/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles*/

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

ModalAsset::register($this);

$this->title = 'Документы';
$this->params['breadcrumbs'][] = ['label' => 'Абитуриенты', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => $profile->getFio(), 'url' => ['default/full', 'user' => $profile->user_id]];
$this->params['breadcrumbs'][] = $this->title;

$anketa = $profile->anketa;
$userId = $profile->user_id;
?>
<div class="row">
        <div class="col-md-12">
            <?= Html::a("Сообщить об ошибке", ['default/send-error', 'user' => $userId], [
                    'class' => 'btn btn-danger',
                'data' => ['method'=>'post', 'confirm'=> "Вы уверены что хотите отправить письмо?"]]) ?>
            <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['view' => 'file-backend', 'userId' => $userId]); ?>

            <?= \modules\entrant\widgets\education\DocumentEducationFileWidget::widget(['view' => 'file-backend', 'userId' => $userId]); ?>

            <?php if (!$anketa->isNoRequired()): ?>
                <?= \modules\entrant\widgets\address\AddressFileWidget::widget(['view' => 'file-backend', 'userId' => $userId]); ?>
            <?php endif; ?>

            <?php if ($anketa->isOrphan()): ?>
                <div class="mt-20 table-responsive">
                    <?= \modules\entrant\widgets\passport\BirthDocumentWidget::widget(['userId' => $userId, 'view' => "file-birth-document-backend"]); ?>
                </div>
            <?php endif; ?>

            <?= \modules\entrant\widgets\other\DocumentOtherFileWidget::widget([ 'view' => 'file-backend', 'userId' => $userId]); ?>
            <?= \modules\entrant\widgets\insurance\InsuranceWidget::widget([ 'view' => 'file-backend', 'userId' => $userId]); ?>
            <?= \modules\entrant\widgets\statement\StatementPersonalDataWidget::widget(['view' => 'index-pd-backend', 'userId' => $userId]); ?>
        </div>
    </div>
