<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statementsCg yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\StatementCg*/
/* @var $agreement modules\entrant\models\StatementAgreementContractCg*/
?>
<?php if($statementsCg):  ?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Договор об оказании платных услуг</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Образовательные программы</th>
            </tr>
            <?php foreach ($statementsCg as $statement):  ?>
                <tr>
                    <td><?= $statement->cg->fullName ?> <?= Html::a('Сформировать договор', ['statement-agreement-contract-cg/create',
                            'id' => $statement->id], ['class' => 'btn btn-info',]) ?> </td>
                </tr>
                 <tr>
                     <td>
                        <table class="table">
                            <?php if($statement->statementAgreement):
                               $agreement =$statement->statementAgreement; ?>
                                <tr class="<?= BlockRedGreenHelper::colorTableBg($agreement->countFiles(), $agreement->count_pages) ?>">
                                    <td></td>
                                    <td><?=  Html::a('Выбрать заказчика договора',
                                            ["statement-agreement-contract-cg/add", "id" => $agreement->id],
                                            ["class" => "btn btn-primary",
                                                'data-pjax' => 'w1', 'data-toggle' => 'modal',
                                                'data-target' => '#modal', 'data-modalTitle' => 'Добавить']); ?>
                                        <?= $agreement->typePersonalOrLegal() ? Html::a('Добавить/редактировать данные 
                                                заказчика договора',
                                            ["statement-agreement-contract-cg/form", "id" => $agreement->id],
                                            ["class" => "btn btn-primary"]) :""; ?>
                                        <?= Html::a('Скачать договор', ['statement-agreement-contract-cg/pdf', 'id' =>  $agreement->id],
                                            ['class' => 'btn btn-large btn-warning'])?>
                                        <?= $agreement->statusDraft() ? Html::a('Удалить',
                                            ['statement-agreement-contract-cg/delete',
                                            'id' =>  $agreement->id],
                                            ['class' => 'btn btn-danger', 'data-method'=>"post",
                                                "data-confirm" => "Вы уверены что хотите удалить?"]) :"" ?>
                                        <?= FileWidget::widget(['record_id' => $agreement->id, 'model' => \modules\entrant\models\StatementAgreementContractCg::class ]) ?>
                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan="2"> <?= FileListWidget::widget(['record_id' => $agreement->id, 'model' => \modules\entrant\models\StatementAgreementContractCg::class,
                                     'userId' => $statement->statement->user_id  ]) ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                     </td>
                 </tr>

            <?php endforeach; ?>
        </table>
<?php endif; ?>