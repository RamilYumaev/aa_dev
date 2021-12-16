<?php

use modules\transfer\helpers\ContractHelper;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\transfer\models\StatementTransfer */
/* @var $agreement modules\transfer\models\StatementAgreementContractTransferCg */

?>
<?php if ($model): ?>
    <h4>Перевод и восстановление</h4>
<table class="table table-bordered">
    <tr>
        <td>
            Заявление <?= $model->numberStatement ?>
        </td>
        <td>
            <span  class="label label-<?=StatementHelper::colorName($model->status)?>"><?= $model->statusName  ?></span>
        </td>
    </tr>
    <?php if($model->message && $model->statusNoAccepted()): ?>
    <tr>
        <td colspan="2"> Причина отклонения: <?=  $model->message ?></td>
    </tr>
    <?php endif; ?>
    <?php if($model->statusAccepted()): ?>
    <tr>
        <td colspan="2" class="bg-warning">Ваши документы проверены и переданы в учебное структурное подразделение.
            Вам необходимо посетить консультацию и аттестационное испытание согласно графику,
            опубликованному на сайте МПГУ: <a href="http://mpgu.su/postuplenie/perevodivosstanovlenie/">
                http://mpgu.su/postuplenie/perevodivosstanovlenie/</a>
        </td>
    </tr>
        <tr>
            <td colspan="2">Данные по аттестации:
                <?php if($model->passExam): ?>
                    <?= '<span class="label label-' .($model->passExam->isPassYes() ? 'success' : 'danger').'">'.($model->passExam->isPassYes() ? 'Допущен' : 'Недопущен').'</span>'; ?> <br />
                    <?= is_null($model->passExam->agree) ? "":'<span class="label label-' .($model->passExam->agree == 1 ? 'success' : 'danger').'">'.
                        ($model->passExam->agree == 1  ? 'Согласен с результатами проведения аттестационной комиссии' : 'Не согласен с результатами проведения аттестационной комиссии').'</span>'; ?>
                    <p> <?= $model->passExam->isPassNo() ? $model->passExam->message : ""?></p>
                    <?= $model->passExam->countFilesSend() ? FileListWidget::widget(['record_id' => $model->passExam->id,
                        'model' => \modules\transfer\models\PassExam::class, 'userId' => $model->user_id]) : ""?>
                    <p><?= $model->passExam->countFilesSend() && is_null($model->passExam->agree) ? Html::a('Я согласен с результатами проведения аттестационной комиссии',['transfer/default/yes', 'id' => $model->id],['data'=>[ 'confirm' => 'Вы уверены, что Вы согласны с результатами проведения аттестационной комиссии?']]) ."<br/>".
                            Html::a('Я не согласен с результатами проведения аттестационной комиссии',['transfer/default/no', 'id' => $model->id], ['data'=>[ 'confirm' => 'В связи с пунктом 3.16 Положения об основаниях и порядке перевода, отчисления и восстановления ( с изм.  и доп. утв. ученым советом МПГУ протокол от 25 мая 2020 г. №7) Пересдача аттестационных испытаний не допускается, подача апелляции не предусмотрена. В связи с чем ваш перевод и/или восстановление будет аннулирован”']])  : ''?></p>
                    <?php if($model->isContract() && $model->passExam->isSuccessExam()): ?>
                     <p class="bg-info">
                         «Вы успешно прошли аттестационные испытания и
                         можете заключить договор об оказании платных образовательных услуг.
                         В связи с эпидемиологической ситуацией данная процедура проводится в дистанционном
                         формате. Для оформления договора необходимо в ответном письме
                         предоставить информацию о заказчике по договору
                         (лицо, ответственное за оплату обучения).»
                     </p>
                    <p><?=  Html::a("Договор на платное обучение","/transfer/post-document/agreement-contract",
                            ['class'=>'pull-right btn btn-info']) ?></p>
                    <?php endif; ?>
                <?php else: ?>
                 нет данных
                <?php endif; ?>
            </td>
        </tr>
            <?php if ($agreement = $model->statementAgreement): ?>
        <tr>
            <td colspan="2">Договор об оказании платных образовательных услуг</td>
        </tr>
            <tr>
                <td>
                    <?= $agreement->statementTransfer->cg->fullNameV ?>
                    <?php if($agreement->message && $agreement->statusNoAccepted()): ?>
                        <br/> Причина отклонения: <?= $agreement->message ?>
                    <?php endif; ?>
                </td>
                <td>
                         <span class="label label-<?= ContractHelper::colorAgreementList()[$agreement->status_id] ?>">
                        <?= $agreement->statusNameStudent ?></span>

                </td>
            </tr>
            <?php if ($agreement->receiptContract): ?>
                <tr>
                    <td>
                        Квитанция
                        <?php if($agreement->receiptContract->message && $agreement->receiptContract->statusNoAccepted()): ?>
                            <br/> Причина отклонения: <?= $agreement->receiptContract->message ?>
                        <?php endif; ?>
                    </td>
                    <td>
                         <span class="label label-<?= ContractHelper::colorName($agreement->receiptContract->status_id) ?>">
                        <?= $agreement->receiptContract->statusName ?></span>
                    </td>
                </tr>
            <?php endif; ?>
                <?php if ($agreement->statusSuccess()): ?>
                <tr>
                    <td colspan="2">
                        <p class="bg-info">
                            Ваш договор подписан со стороны Исполнителя (ВУЗа). <br />
                            Выдача договоров об оказании платных образовательных услуг ведется строго по предварительной записи. Записаться возможно по номеру телефона 8(495)438-18-57. <br/>
                            В случае если заказчик и обучающийся разные лица на подписании необходимо присутствие как заказчика, так и обучающегося
                        </p>
                    </td>
                </tr>
            <?php endif; ?>
            <?php endif; ?>
    <?php endif; ?>
</table>
<?php endif; ?>