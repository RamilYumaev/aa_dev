<?php
/* @var $this yii\web\View */
/* @var $contract modules\entrant\models\StatementAgreementContractCg */

use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);

$this->title = $contract->statementCg->statement->profileUser->fio;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \modules\entrant\widgets\contract\ContractWidget::widget(['model' => $contract ]); ?>
