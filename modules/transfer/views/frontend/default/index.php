<?php
/* @var $this yii\web\View */
/* @var  $transfer  modules\transfer\models\TransferMpgu */
use yii\helpers\Html;

$this->title = 'Персональная карточка';
$userId = $transfer->user_id;
$this->params['breadcrumbs'][] = ['label' => 'Определение условий', 'url' => ['/transfer/default/fix']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?=$this->title?></h1>
    <div class="row min-scr">
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\profile\ProfileWidget::widget(['userId' => $userId, 'referrer'=> 'transfer-registration']); ?>
        </div>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\address\AddressWidget::widget(['userId' => $userId, 'referrer'=> 'transfer-registration']); ?>
        </div>
        <div class="mt-20 table-responsive">
            <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['userId' => $userId,'view' => "detail", 'referrer'=> 'transfer-registration']); ?>
        </div>
        <?php if(!$transfer->isMpgu()): ?>
        <div class="mt-20 table-responsive">
            <?= \modules\transfer\widgets\education\DocumentEducationWidget::widget(['userId' => $userId, 'referrer'=> 'transfer-registration']); ?>
        </div>
        <?php endif; ?>
        <div class="mt-20 table-responsive">
            <?= \modules\transfer\widgets\transfer\TransferWidget::widget(['userId' => $userId,]); ?>
        </div>
        <div class="mt-20">
            <div class="col-md-offset-4 col-md-4">
                <?= Html::a("Загрузка сканов", ['post-document/index'], ["class" => "btn btn-warning btn-lg", 'data'=> ['method' => 'post']]) ?>
            </div>
        </div>
    </div>
</div>