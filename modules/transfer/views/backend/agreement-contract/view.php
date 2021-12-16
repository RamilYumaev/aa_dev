<?php
/* @var $this yii\web\View */
/* @var $contract modules\entrant\models\StatementAgreementContractCg */

use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

$this->title = $contract->statementTransfer->profileUser->fio;
$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Договоры ПиВ', 'url' => ['default/contract']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \modules\transfer\widgets\contract\ContractWidget::widget(['model' => $contract ]); ?>
