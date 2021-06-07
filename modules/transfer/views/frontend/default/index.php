<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Персональная карточка';

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
        <div class="mt-20 table-responsive">
            <?= \modules\transfer\widgets\education\DocumentEducationWidget::widget(['userId' => $userId, 'referrer'=> 'transfer-registration']); ?>
        </div>
        <div class="mt-20 table-responsive">
            <?= \modules\transfer\widgets\transfer\TransferWidget::widget(['userId' => $userId,]); ?>
        </div>
    </div>
</div>
