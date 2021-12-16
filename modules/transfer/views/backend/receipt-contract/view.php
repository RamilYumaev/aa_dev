<?php
/* @var $this yii\web\View */
/* @var $receipt modules\entrant\models\ReceiptContract */

use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

$this->title = "Квитанция";
$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Договоры ПиВ', 'url' => ['default/contract']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \modules\transfer\widgets\contract\ReceiptContractWidget::widget(['model' => $receipt ]); ?>
<?= \modules\transfer\widgets\contract\ContractWidget::widget(['model' =>$receipt->contractCg ]); ?>
