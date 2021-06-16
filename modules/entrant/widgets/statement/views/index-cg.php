<?php

use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statementsCg yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\StatementCg */
/* @var $consent modules\entrant\models\StatementConsentCg */
/* @var $isUserSchool bool */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Заявление о согласии на зачисление</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Образовательные программы</th>
            </tr>
            <?php foreach ($statementsCg as $statement): ?>
                <tr>
                    <td><?= $statement->cg->fullNameB ?> <?= Html::a('Сформировать заявление', ['statement-consent-cg/create',
                            'id' => $statement->id], ['class' => 'btn btn-info pull-right',
                            'data'=> ['confirm'=> $statement->cg->isBudget() ?
                                'Заявление о согласии на зачисление на бюджет можно подавать не более 3-х раз в университет. Вы уверены, что хотите продолжить?' :
                                "Вы уверены, что хотите сформировать заявление о согласии на зачисление?"]]) ?> </td>
                </tr>
                <tr>
                    <td>
                        <table class="table">
                            <?php foreach ($statement->statementConsent as $consent): ?>
                                <tr class="<?= BlockRedGreenHelper::colorTableBg($consent->countFiles(), $consent->count_pages) ?>">
                                    <td></td>
                                    <td><?= Html::a('Скачать заявление', ['statement-consent-cg/pdf', 'id' => $consent->id],
                                            ['class' => 'btn btn-large btn-warning']) ?>
                                        <?= $consent->statusDraft() ? Html::a('Удалить', ['statement-consent-cg/delete',
                                            'id' => $consent->id,],
                                            ['class' => 'btn btn-danger', 'data-method' => "post",
                                                "data-confirm" => "Вы уверены что хотите удалить?"]) : "" ?>
                                        <?= FileWidget::widget(['record_id' => $consent->id, 'model' => \modules\entrant\models\StatementConsentCg::class]) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <?= FileListWidget::widget(['record_id' => $consent->id, 'model' => \modules\entrant\models\StatementConsentCg::class, 'userId' => $statement->statement->user_id]) ?></td>
                                </tr>
                                <?php if ($consent->isStatusAccepted()): ?>
                                    <tr>
                                        <td>
                                            <?= $consent->statementCgRejection ?
                                                (!$consent->statementCgRejection->isStatusAccepted() ?
                                                    Html::a("Удалить отзыв", ['statement-consent-cg/rejection-remove', 'id' => $consent->statementCgRejection->id], ['class' => 'btn btn-danger', 'data' => [
                                                        'confirm' => "Вы уверены, что хотите отозвать заявление?",
                                                        'method' => 'post']]) : "") :
                                                Html::a("Отозвать", ['statement-consent-cg/rejection', 'id' => $consent->id], ['class' => 'btn btn-info', 'data' => [
                                                    'confirm' => "Вы уверены, что хотите отозвать заявление?",
                                                    'method' => 'post']]) ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($consent->statementCgRejection) : ?>
                                    <tr <?= BlockRedGreenHelper::colorTableBg($consent->statementCgRejection->countFiles(), $consent->statementCgRejection->count_pages) ?>>
                                        <td>
                                        <td><?= Html::a('Скачать заявление', ['statement-rejection/pdf-consent', 'id' => $consent->statementCgRejection->id],
                                                ['class' => 'btn btn-large btn-warning']) ?> <?= $consent->statementCgRejection->isStatusAccepted() ? "" : FileWidget::widget([
                                                'record_id' => $consent->statementCgRejection->id,
                                                'model' => \modules\entrant\models\StatementRejectionCgConsent::class]) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?= FileListWidget::widget(['record_id' => $consent->statementCgRejection->id, 'model' => \modules\entrant\models\StatementRejectionCgConsent::class, 'userId' => $statement->statement->user_id]) ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>

            <?php endforeach; ?>
        </table>