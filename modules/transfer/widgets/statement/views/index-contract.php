<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\transfer\helpers\ContractHelper;
use yii\helpers\Html;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\transfer\models\StatementTransfer    */
/* @var $agreement modules\transfer\models\StatementAgreementContractTransferCg */

?>
<?php if ($statements): ?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Договор об оказании платных образовательных услуг</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Образовательные программы</th>
            </tr>
            <?php foreach ($statements as $statement): $agreement = $statement->statementAgreement;?>
                <tr>
                    <td><?= $statement->cg ? $statement->cg->fullNameCg : "" ?>
                        <?= !$agreement ? Html::a('Создать договор', ['statement-agreement-contract-transfer-cg/create',
                            'id' => $statement->id], ['class' => 'btn btn-info',]) :
                            ('<span class="label label-'.ContractHelper::colorAgreementList()[$agreement ->status_id].'">'.$agreement->statusNameStudent.'</span>'); ?> </td>
                </tr>
                 <?php if ($agreement) : ?>
                <tr>
                    <td> Заказчик образовательных услуг: <?= !is_null($agreement->type) ? ContractHelper::typeList()[$agreement->type] : ""?>.
                        <?= $agreement->statusCreated() ? Html::a('Сообщить об ошибке', ['statement-agreement-contract-transfer-cg/message',
                            'id' => $agreement->id],  ["class" => "btn btn-danger pull-right",
                            'data-pjax' => 'w444', 'data-toggle' => 'modal',
                            'data-target' => '#modal', 'data-modalTitle' => 'Сообщение об ошибке']) : "" ?> </td>
                </tr>
                 <?php endif;?>
                <tr>
                    <td>
                        <table class="table">
                            <?php if ($agreement):?>
                                <tr>
                                    <td colspan="2"> <?= $agreement->statusDraft() ? Html::a('Выбрать заказчика договора',
                                            ["statement-agreement-contract-transfer-cg/add", "id" => $agreement->id],
                                            ["class" => "btn btn-primary",
                                                'data-pjax' => 'w1', 'data-toggle' => 'modal',
                                                'data-target' => '#modal', 'data-modalTitle' => 'Кто выступает в роли заказчика?']) : ""; ?>
                                        <?= ($agreement->typePersonalOrLegal() && $agreement->statusDraft()) ||
                                        ($agreement->typePersonalOrLegal() && $agreement->statusNoAccepted()) ? Html::a('Добавить/редактировать данные 
                                                заказчика договора',
                                            ["statement-agreement-contract-transfer-cg/form", "id" => $agreement->id],
                                            ["class" => "btn btn-primary"]) : ""; ?>
                                        <?= $agreement->pdf_file && ($agreement->statusCreated() || $agreement->statusAcceptedStudent() || $agreement->statusAccepted()) ? Html::a('Скачать договор', ['statement-agreement-contract-transfer-cg/get', 'id' => $agreement->id],
                                            ['class' => 'btn btn-large btn-primary']) : "" ?>
                                        <?= $agreement->statusDraft() ? Html::a('Удалить',
                                            ['statement-agreement-contract-transfer-cg/delete',
                                                'id' => $agreement->id],
                                            ['class' => 'btn btn-danger', 'data-method' => "post",
                                                "data-confirm" => "Вы уверены что хотите удалить?"]) : "" ?>
                                        <?= $agreement->number && $agreement->pdf_file && $agreement->statusCreated() ? FileWidget::widget(['record_id' => $agreement->id, 'model' => \modules\transfer\models\StatementAgreementContractTransferCg::class]) : "" ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <?= FileListWidget::widget(['record_id' => $agreement->id, 'model' => \modules\transfer\models\StatementAgreementContractTransferCg::class,
                                            'userId' => $statement->user_id]) ?></td>
                                </tr>
                                <?php if ($agreement->typePersonalOrLegal()): ?>
                                <?php if ($agreement->typePersonal()): ?>
                                    <tr>
                                        <td>Данные о законном представителе - Заказчике платных образовательных услуг:
                                            <?= $agreement->personal->dataFull ?></td>
                                        <td>Необходимо загрузить паспортные данные Заказчика</td>
                                    </tr>
                                    <tr>
                                        <td><?= FileWidget::widget(['record_id' => $agreement->personal->id, 'model' => \modules\transfer\models\PersonalEntityTransfer::class]) ?></td>
                                        <td><?= FileListWidget::widget(['record_id' => $agreement->personal->id, 'model' => \modules\transfer\models\PersonalEntityTransfer::class,
                                                'userId' => $statement->user_id]) ?></td>
                                    </tr>
                                <?php elseif ($agreement->typeLegal()): ?>
                                    <tr>
                                        <td>Данные о Юридическом лице - Заказчике платных образовательных услуг:
                                            <?= $agreement->legal->dataFull ?></td>
                                        <td>Необходимо загрузить паспортные данные Заказчика и карту предприятия</td>
                                    </tr>
                                    <tr>
                                        <td> <?= FileWidget::widget(['record_id' => $agreement->legal->id, 'model' => \modules\transfer\models\LegalEntityTransfer::class]) ?></td>
                                        <td> <?= FileListWidget::widget(['record_id' => $agreement->legal->id, 'model' => \modules\transfer\models\LegalEntityTransfer::class,
                                                'userId' => $statement->user_id]) ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                                <?php if ($agreement->statusGroupAccepted()  && $agreement->receiptContract): ?>
                                <tr>
                                    <td colspan="2">
                                        <?= Html::a('Скачать квитанцию', ['statement-agreement-contract-transfer-cg/get-receipt', 'id' => $agreement->id],
                                            ['class' => 'btn btn-large btn-warning']) ?>
                                        <?= $agreement->receiptContract->isNullData() ? Html::a('Добавить данные квитанции',
                                            ["statement-agreement-contract-transfer-cg/update-receipt", "id" => $agreement->receiptContract->id],
                                            ["class" => "btn btn-primary",
                                                'data-pjax' => 'w4', 'data-toggle' => 'modal',
                                                'data-target' => '#modal', 'data-modalTitle' => 'Данные квитанции']) :
                                            (!$agreement->receiptContract->statusAccepted() ? Html::a('Редактировать данные квитанции',
                                                ["statement-agreement-contract-transfer-cg/update-receipt", "id" => $agreement->receiptContract->id],
                                                ["class" => "btn btn-primary",
                                                    'data-pjax' => 'w4', 'data-toggle' => 'modal',
                                                    'data-target' => '#modal', 'data-modalTitle' => 'Данные квитанции']) : ""); ?>
                                    </td>
                                </tr>
                                <?php if (!$agreement->receiptContract->isNullData()): ?>
                                    <tr>
                                    <td colspan="2">
                                        <?= FileWidget::widget(['record_id' => $agreement->receiptContract->id, 'model' => \modules\transfer\models\ReceiptContractTransfer::class]) ?>
                                        <?= FileListWidget::widget(['record_id' => $agreement->receiptContract->id, 'model' => \modules\transfer\models\ReceiptContractTransfer::class,
                                            'userId' => $statement->user_id]) ?>
                                    </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php endif; ?>

                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p> Нет данных.
        <p>
            <?php endif; ?>
