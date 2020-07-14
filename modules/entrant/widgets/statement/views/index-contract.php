<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statementsCg yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\StatementCg */
/* @var $agreement modules\entrant\models\StatementAgreementContractCg */
?>
<?php if ($statementsCg): ?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Договор об оказании платных образовательных услуг</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Образовательные программы</th>
            </tr>
            <?php foreach ($statementsCg as $statement): ?>
                <tr>
                    <td><?= $statement->cg->fullNameB ?> <?= !$statement->statementAgreement ? Html::a('Создать договор', ['statement-agreement-contract-cg/create',
                            'id' => $statement->id], ['class' => 'btn btn-info',]) : "" ?> </td>
                </tr>
                <tr>
                    <td>
                        <table class="table">
                            <?php if ($statement->statementAgreement):
                                $agreement = $statement->statementAgreement; ?>
                                <tr class="<?= BlockRedGreenHelper::colorTableBg($agreement->countFiles(), $agreement->count_pages) ?>">
                                    <td colspan="2"> <?= !$agreement->number ? Html::a('Выбрать заказчика договора',
                                            ["statement-agreement-contract-cg/add", "id" => $agreement->id],
                                            ["class" => "btn btn-primary",
                                                'data-pjax' => 'w1', 'data-toggle' => 'modal',
                                                'data-target' => '#modal', 'data-modalTitle' => 'Кто выступает в роли заказчика?']) : ""; ?>
                                        <?= $agreement->typePersonalOrLegal() && !$agreement->number ? Html::a('Добавить/редактировать данные 
                                                заказчика договора',
                                            ["statement-agreement-contract-cg/form", "id" => $agreement->id],
                                            ["class" => "btn btn-primary"]) : ""; ?>
                                        <?= $agreement->number ? Html::a('Скачать договор', ['statement-agreement-contract-cg/pdf', 'id' => $agreement->id],
                                            ['class' => 'btn btn-large btn-warning']) : Html::a('Сформировать договор', ['statement-agreement-contract-cg/create-pdf', 'id' => $agreement->id],
                                            ['class' => 'btn btn-large btn-warning']) ?>
                                        <?= $agreement->pdf_file && $agreement->statusSuccess() ? Html::a('Скачать подписанный договор', ['statement-agreement-contract-cg/get', 'id' => $agreement->id],
                                            ['class' => 'btn btn-large btn-primary']) : "" ?>
                                        <?= $agreement->statusDraft() ? Html::a('Удалить',
                                            ['statement-agreement-contract-cg/delete',
                                                'id' => $agreement->id],
                                            ['class' => 'btn btn-danger', 'data-method' => "post",
                                                "data-confirm" => "Вы уверены что хотите удалить?"]) : "" ?>
                                        <?= $agreement->number ? FileWidget::widget(['record_id' => $agreement->id, 'model' => \modules\entrant\models\StatementAgreementContractCg::class]) : "" ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <?= FileListWidget::widget(['record_id' => $agreement->id, 'model' => \modules\entrant\models\StatementAgreementContractCg::class,
                                            'userId' => $statement->statement->user_id]) ?></td>
                                </tr>
                                <?php if ($agreement->typePersonalOrLegal()): ?>
                                <?php if ($agreement->typePersonal()): ?>
                                    <tr>
                                        <td>Данные о законном представителе - Заказчике платных образовательных услуг:
                                            <?= $agreement->personal->dataFull ?></td>
                                        <td>Необходимо загрузить паспортные данные Заказчика</td>
                                    </tr>
                                    <tr>
                                        <td><?= FileWidget::widget(['record_id' => $agreement->personal->id, 'model' => \modules\entrant\models\PersonalEntity::class]) ?></td>
                                        <td><?= FileListWidget::widget(['record_id' => $agreement->personal->id, 'model' => \modules\entrant\models\PersonalEntity::class,
                                                'userId' => $statement->statement->user_id]) ?></td>
                                    </tr>
                                <?php elseif ($agreement->typeLegal()): ?>
                                    <tr>
                                        <td>Данные о Юридическом лице - Заказчике платных образовательных услуг:
                                            <?= $agreement->legal->dataFull ?></td>
                                        <td>Необходимо загрузить паспортные данные Заказчика и карту предприятия</td>
                                    </tr>
                                    <tr>
                                        <td> <?= FileWidget::widget(['record_id' => $agreement->legal->id, 'model' => \modules\entrant\models\LegalEntity::class]) ?></td>
                                        <td> <?= FileListWidget::widget(['record_id' => $agreement->legal->id, 'model' => \modules\entrant\models\LegalEntity::class,
                                                'userId' => $statement->statement->user_id]) ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                                <?php if ($agreement->receiptContract): ?>
                                <tr>
                                    <td colspan="2">
                                        <?= Html::a('Скачать квитанцию', ['statement-agreement-contract-cg/pdf-receipt', 'id' => $agreement->receiptContract->id],
                                            ['class' => 'btn btn-large btn-warning']) ?>
                                        <?= $agreement->receiptContract->statusDraft() ? Html::a('Удалить', ['statement-agreement-contract-cg/delete-receipt', 'id' => $agreement->receiptContract->id],
                                            ['class' => 'btn btn-danger', 'data-method' => "post",
                                                "data-confirm" => "Вы уверены что хотите удалить?"]) : ""?>
                                        <?= $agreement->receiptContract->isNullData() ? Html::a('Добавить данные квитанции',
                                            ["statement-agreement-contract-cg/update-receipt", "id" => $agreement->receiptContract->id],
                                            ["class" => "btn btn-primary",
                                                'data-pjax' => 'w4', 'data-toggle' => 'modal',
                                                'data-target' => '#modal', 'data-modalTitle' => 'Данные квитанции']) :
                                            (!$agreement->receiptContract->statusAccepted() ? Html::a('Редактировать данные квитанции',
                                                ["statement-agreement-contract-cg/update-receipt", "id" => $agreement->receiptContract->id],
                                                ["class" => "btn btn-primary",
                                                    'data-pjax' => 'w4', 'data-toggle' => 'modal',
                                                    'data-target' => '#modal', 'data-modalTitle' => 'Данные квитанции']) : ""); ?>
                                    </td>
                                </tr>
                                <?php if (!$agreement->receiptContract->isNullData()): ?>
                                    <tr>
                                    <td colspan="2">
                                        <?= FileWidget::widget(['record_id' => $agreement->receiptContract->id, 'model' => \modules\entrant\models\ReceiptContract::class]) ?>
                                        <?= FileListWidget::widget(['record_id' => $agreement->receiptContract->id, 'model' => \modules\entrant\models\ReceiptContract::class,
                                            'userId' => $statement->statement->user_id]) ?>
                                    </td>

                                    </tr>
                                <?php endif; ?>

                            <?php else: ?>
                                <tr>
                                    <td><?= $agreement->statusAccepted() ? Html::a('Сформировать квитанцию',
                                            ["statement-agreement-contract-cg/add-receipt", "id" => $agreement->id],
                                            ["class" => "btn btn-primary",
                                                'data-pjax' => 'w3', 'data-toggle' => 'modal',
                                                'data-target' => '#modal', 'data-modalTitle' => 'Квитанция']) : ""; ?>
                                    </td>

                                </tr>

                            <?php endif; ?>
                            <?php endif; ?>

                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p> Вы не сформиировали заявление о согласии на зачисление или данное заявление не имеет статус "Принято"
        <p>
            <?php endif; ?>
