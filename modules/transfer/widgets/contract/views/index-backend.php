<?php

use backend\widgets\adminlte\Box;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\transfer\helpers\ContractHelper;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\transfer\models\StatementAgreementContractTransferCg */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Договор"  , "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    );?>
     <h4><?= $model->message_st ? "Cообщение от студента: ".$model->message_st: ""?></h4>
    <?= $model->statusWalt() ? Html::a('Взять в работу', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_VIEW],
    ['class' => 'btn btn-large btn-info', 'data'=>['confirm'=> "Вы уверены, что хотите взять в  работу?"]]) : ""?>
    <?= $model->statusAcceptedStudent() ? Html::a('Принять', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_ACCEPTED],
    ['class' => 'btn btn-large btn-success', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : ""?>
    <?=  $model->statusAccepted() && $model->pdf_file ? Html::a('Отправить на подписание', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_SEND_SUCCESS],
    ['class' => 'btn btn-large btn-primary', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : ""?>
    <?=  $model->statusSendStatus() && $model->pdf_file ? Html::a('Подписан', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_SUCCESS],
    ['class' => 'btn btn-large btn-primary', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : ""?>
    <?=  $model->statusWalt() || $model->statusFix() || $model->statusView() ? Html::a("Прикрепить файл  (pdf)", ['agreement-contract/file-pdf', 'id' =>  $model->id, ], ["class" => "btn btn-warning",
    'data-pjax' => 'w5', 'data-toggle' => 'modal',
    'data-target' => '#modal', 'data-modalTitle' => 'Загрузить файл']) : "" ?>
    <?=  Html::a("Прикрепить квитанцию  (pdf)", ['agreement-contract/file-pdf-receipt', 'id' =>  $model->id, ], ["class" => "btn btn-warning",
    'data-pjax' => 'w5', 'data-toggle' => 'modal',
    'data-target' => '#modal', 'data-modalTitle' => 'Загрузить файл']) ?>
    <?= $model->pdf_file  ? Html::a("Скачать файл", ['agreement-contract/get', 'id' =>  $model->id ], ["class" => "btn btn-info"]) : "" ?>
    <?= $model->receiptContract ? Html::a("Скачать квитанцию", ['agreement-contract/get-receipt', 'id' =>  $model->id ], ["class" => "btn btn-info"]) : "" ?>
    <?= $model->statusWalt() || $model->statusView()   ? Html::a("Отклонить", ["agreement-contract/message", 'id' => $model->id], ["class" => "btn btn-danger",
    'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения заявления']) :"" ?>
    <?= $model->statusNoAccepted()  || $model->statusCreated() ? Html::a('Возврат', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_WALT],
    ['class' => 'btn btn-warning', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : "" ?>
    <?= Html::a("Сообщить об ошибке", ['profiles/send-error', 'user' => $model->statementTransfer->transferMpgu->id], [
    'class' => 'btn btn-danger',
    'data' => ['method' => 'post', 'confirm' => "Вы уверены что хотите отправить письмо?"]]) ?>

    <div class="row">
        <div class="col-md-4">

    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                        'statementTransfer.cg.faculty.full_name',
                    'statementTransfer.cg.fullNameCg',
                    'number',
                    'statementTransfer.profileUser.fio',
                    'statusName',
                    'created_at:date',
                    'updated_at:date',
                ]
            ])
    ?></div>
        <div class="col-md-8">
        <?= \modules\transfer\widgets\passport\PassportMainWidget::widget(['view' => 'file-backend', 'userId' =>  $model->statementTransfer->user_id]); ?>
        <?= \modules\transfer\widgets\address\AddressFileWidget::widget(['view' => 'file-backend', 'userId' => $model->statementTransfer->user_id]); ?>
        <?= \modules\transfer\widgets\insurance\InsuranceWidget::widget([ 'view' => 'file-backend', 'userId' => $model->statementTransfer->user_id]); ?>
            </div>
    </div>

    <?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id,
    'model' => $model::className(), 'userId' => $model->statementTransfer->user_id]) ?>
     <?php if ($model->typeLegal()): ?>
      <?= $this->render('legal', ['model'=> $model->legal]); ?>
     <?php elseif ($model->typePersonal()): ?>
    <?= $this->render('personal', ['model'=> $model->personal]); ?>
     <?php endif; ?>
    <?php Box::end(); endif; ?>
