<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statementConsents yii\db\BaseActiveRecord */
/* @var $consent modules\entrant\models\StatementConsentCg*/
/* @var $isUserSchool bool */

?>
<?php if($statementConsents): ?>

<?php  Box::begin(
    [
        "header" =>"Заявление о согласии на зачисление",
        "type" => Box::TYPE_PRIMARY,
        "filled" => true,]) ?>
<?php foreach ($statementConsents as $consent): ?>
    <table class="table">
        <tr>
            <th><?=$consent->statementCg->cg->fullName?></th>
            <td><?= Html::a('Скачать заявление', ['statement-consent-cg/pdf', 'id' =>  $consent->id],
                    ['class' => 'btn btn-large btn-warning'])?>
                <?= $consent->statusAccepted() ? Html::a('Скачать расписку', ['statement-consent-cg/receipt', 'id' =>  $consent->id],
                    ['class' => 'btn btn-large btn-info']) : ""?>
                <?php if($consent->statusAccepted()): ?>
                    <p> Простановка оригинала документа об образовании</p>
                    <?php if($consent->check_original): ?>
                        <?= Html::a('Отозвать',  ['communication/export-statement-consent-reset',
                            'user' => $consent->statementCg->statement->user_id,
                            'statement' =>$consent->statementCg->statement->id,
                            'consent' =>  $consent->id],
                            ['data-method' => 'post', 'class' => 'btn btn-danger', "data-confirm" => "Вы уверены, что хотите это сделаать?"])?>
                    <?php else: ?>
                        <?= Html::a('Принять', ['communication/export-statement-consent-success',
                            'user' => $consent->statementCg->statement->user_id,
                            'statement' =>$consent->statementCg->statement->id,
                            'consent' =>  $consent->id],
                            ['data-method' => 'post', 'class' => 'btn btn-success', "data-confirm" => "Вы уверены, что хотите это сделаать?"])?>
                    <?php endif ?>
                <?php endif ?>
            </td>
            <td><span class="label label-<?= StatementHelper::colorName($consent->status)?>">
                        <?=$consent->statusNameJob?></span></td>
            <td>
                <?= ($consent->statusWalt() || $consent->statusView()) && $consent->isAllFilesAccepted() && $consent->statementCg->statement->statusAccepted() ?
                Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
                ['communication/export-statement-consent',
                'user' => $consent->statementCg->statement->user_id,
                'statement' =>$consent->statementCg->statement->id,
                'consent' =>  $consent->id],
                ['data-method' => 'post', 'class' => 'btn btn-info']) : "" ?>
                <?= $consent->statusWalt()  ? Html::a('Взять в работу', ['statement-consent-cg/status-view', 'id' => $consent->id, ],
                    ['class' => 'btn btn-info', 'data' =>["confirm" => "Вы уверены, что хотите взять заявление в работу?"]]) : "" ?>
                <?= $consent->statusView() || $consent->isStatusNoAccepted() ? Html::a('Возврат', ['statement-consent-cg/status-reset', 'id' => $consent->id, ],
                    ['class' => 'btn btn-warning', 'data' =>["confirm" => "Вы уверены, что хотите сделать возврат?"]]) : "" ?>
                <?= $consent->statusWalt() ? Html::a("Отклонить", ["statement-consent-cg/status-no",  'id' => $consent->id], ["class" => "btn btn-danger",
                'data' =>["confirm" => 'Вы уверены что хотите отклонить ЗОС']]) :"" ?>
            </td>
        </tr>
    </table>
    <?= FileListBackendWidget::widget(['record_id' => $consent->id,
        'model' => \modules\entrant\models\StatementConsentCg::class,
        'isCorrect'=> $consent->statusAccepted(),
        'userId' => $consent->statementCg->statement->user_id  ]) ?>
    <?php if($consent->statementCgRejection) : ?>
            <?php  Box::begin(
                [
                    "header" =>"Отозванное ЗОС",
                    "type" => Box::TYPE_DANGER,
                    "filled" => true,]) ?>
            <p>
                <?= Html::a('Скачать заявление', ['statement-rejection/pdf-consent', 'id' =>  $consent->statementCgRejection->id],
                    ['class' => 'btn btn-large btn-warning'])?>
                <?=  ($consent->statementCgRejection->statusNewJob() ||
                    $consent->statementCgRejection->isStatusView()) &&  $consent->statementCgRejection->isAllFilesAccepted() ?
                    Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
                        ['/data-entrant/communication/export-statement-consent-remove',
                            'user' =>   $consent->statementCg->statement->user_id, 'statement' =>  $consent->statementCg->statement->id, 'consent' => $consent->statementCgRejection->id],
                        ['data-method' => 'post', 'class' => 'btn btn-success']) : '';  ?>
                <?=  $consent->statementCgRejection->statusNewJob() ||
                $consent->statementCgRejection->isStatusView() ? Html::a("Отклонить", ["statement-rejection/message-consent",  'id' => $consent->statementCgRejection->id], ["class" => "btn btn-danger",
                    'data-pjax' => 'w8', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения отозванного заявления ЗОС']) :"" ?>
                <?=  $consent->statementCgRejection->isStatusView() || $consent->statementCgRejection->isStatusNoAccepted() ? Html::a('Возврат', ['statement-rejection/status-consent', 'id' => $consent->statementCgRejection->id, 'status'=>StatementHelper::STATUS_WALT],
                    ['class' => 'btn btn-success']) : "" ?>
                <?=  $consent->statementCgRejection->statusNewJob()  ? Html::a('Взять в работу', ['statement-rejection/status-view-consent', 'id' => $consent->statementCgRejection->id, ],
                    ['class' => 'btn btn-info', 'data' =>["confirm" => "Вы уверены, что хотите взять заявление в работу?"]]) : "" ?>
                <span class="label label-<?= StatementHelper::colorName( $consent->statementCgRejection->status_id)?>">
                        <?=  $consent->statementCgRejection->statusNameJob?></span>
            </p>

            <?= FileListBackendWidget::widget([ 'record_id' =>  $consent->statementCgRejection->id, 'isCorrect'=>  $consent->statementCgRejection->isStatusAccepted(), 'model' => \modules\entrant\models\StatementRejectionCgConsent::class, 'userId' =>  $consent->statementCg->statement->user_id, ]) ?>
            <?php Box::end() ?>



        <?php endif; ?>
<?php endforeach; Box::end(); endif; ?>
