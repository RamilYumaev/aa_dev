<?php
/* @var $this yii\web\View */
/* @var $receipt modules\entrant\models\ReceiptContract */

use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

$this->title = "Квитанция";
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \modules\entrant\widgets\contract\ReceiptContractWidget::widget(['model' => $receipt ]); ?>
<?= \modules\entrant\widgets\contract\ContractWidget::widget(['model' =>$receipt->contractCg ]); ?>
