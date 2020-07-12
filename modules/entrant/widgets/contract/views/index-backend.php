<?php

use backend\widgets\adminlte\Box;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\StatementAgreementContractCg */
?>
<?php if ($model) :
    Box::begin(
        ["header" => "Договор"  , "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    );?>

    <?= $model->statusWalt() ? Html::a('Взять в работу', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_VIEW],
    ['class' => 'btn btn-large btn-info', 'data'=>['confirm'=> "Вы уверены, что хотите взять в  работу?"]]) : ""?>
    <?= $model->statusWalt() || $model->statusView() ? Html::a('Проверен', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_ACCEPTED],
    ['class' => 'btn btn-large btn-success', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : ""?>
    <?=  $model->statusAccepted() && $model->pdf_file ? Html::a('Подписан', ['communication/export-contract', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_SUCCESS],
    ['class' => 'btn btn-large btn-primary', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) ." ". Html::a('Недействительный', ['communication/export-contract', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_NO_REAL],
        ['class' => 'btn btn-large btn-danger', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : ""?>
    <?=  $model->statusAccepted() ? Html::a("Прикрепить файл  (pdf)", ['agreement-contract/file-pdf', 'id' =>  $model->id, ], ["class" => "btn btn-warning",
    'data-pjax' => 'w5', 'data-toggle' => 'modal',
    'data-target' => '#modal', 'data-modalTitle' => 'Загрузить файл']) : "" ?>
    <?php if(\Yii::$app->user->can('month-receipt')): ?>
    <?= !$model->is_month ? Html::a('Оплата по месяцам "Да"', ['agreement-contract/is-month', 'id' =>  $model->id, 'status' => DictDefaultHelper::YES],
    ['class' => 'btn btn-large btn-success', 'data'=>['confirm'=> "Вы уверены, что хотите  предоставть оплату по месяцам?"]]) : Html::a('Оплата по месяцам "Нет"', ['agreement-contract/is-month',
    'id' =>  $model->id, 'status' => DictDefaultHelper::NO],
    ['class' => 'btn btn-large btn-danger', 'data'=>['confirm'=> "Вы уверены, что хотите  отменить оплату по месяцам?"]])?>
    <?php endif; ?>
    <?= $model->pdf_file  ? Html::a("Скачать файл", ['agreement-contract/get', 'id' =>  $model->id ], ["class" => "btn btn-info"]) : "" ?>
    <?= Html::a('Скачать договор', ['agreement-contract/pdf', 'id' =>  $model->id],
    ['class' => 'btn btn-large btn-warning pull-right'])?>
    <?= $model->statusWalt() || $model->statusView()   ? Html::a("Отклонить", ["agreement-contract/message", 'id' => $model->id], ["class" => "btn btn-danger",
    'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения заявления']) :"" ?>
    <?= $model->statusNoAccepted()  ? Html::a('Возврат', ['agreement-contract/status', 'id' =>  $model->id, 'status' => ContractHelper::STATUS_WALT],
    ['class' => 'btn btn-warning', 'data'=>['confirm'=> "Вы уверены, что хотите изменить статус договора?"]]) : "" ?>
    <?= Html::a("Сообщить об ошибке", ['default/send-error', 'user' => $model->statementCg->statement->user_id], [
    'class' => 'btn btn-danger',
    'data' => ['method' => 'post', 'confirm' => "Вы уверены что хотите отправить письмо?"]]) ?>

    <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                    'cg',
                    'number',
                    'fio',
                    'statusName',
                     'isMonth',
                    'created_at:date',
                    'updated_at:date',
                ]
            ]) ?>

    <?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id,
    'model' => $model::className(), 'userId' => $model->statementCg->statement->user_id]) ?>
     <?php if ($model->typeLegal()): ?>
      <?= $this->render('legal', ['model'=> $model->legal]); ?>
     <?php elseif ($model->typePersonal()): ?>
    <?= $this->render('personal', ['model'=> $model->personal]); ?>
     <?php endif; ?>
    <?php Box::end(); endif; ?>
