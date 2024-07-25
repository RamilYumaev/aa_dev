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
        <?php if(!$model->is_gia): ?>
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
                            <?= '<span class="label label-' .($model->passExam->isPassYes() ? 'success' : 'danger').'">'.($model->passExam->isPassYes() ? 'Допущен' : 'Не допущен').'</span>'; ?> <br />
                            <?= $model->passExam->examStatement ? Html::a("Аттестация", "/exam", ['class' => 'pull-right btn btn-danger']) : ""?>
                            <?= is_null($model->passExam->agree) ? "":'<span class="label label-' .($model->passExam->agree == 1 ? 'success' : 'danger').'">'.
                                ($model->passExam->agree == 1  ? 'Согласен с результатами проведения аттестационной комиссии' : 'Не согласен с результатами проведения аттестационной комиссии').'</span>'; ?>
                            <p> <?= $model->passExam->isPassNo() ? $model->passExam->message : ""?></p>
                            <?= $model->passExam->passExamStatement && $model->passExam->passExamStatement->countFilesSend() ? FileListWidget::widget(['record_id' => $model->passExam->passExamStatement->id,
                                'model' => \modules\transfer\models\PassExamStatement::class, 'userId' => $model->user_id]) : ""?>
                            <?= $model->passExam->passExamProtocol && $model->passExam->passExamProtocol->countFilesSend() ? FileListWidget::widget(['record_id' => $model->passExam->passExamProtocol->id,
                            'model' => \modules\transfer\models\PassExamProtocol::class, 'userId' => $model->user_id]) : ""?>
                            <p><?= (($model->passExam->passExamStatement && $model->passExam->passExamStatement->countFilesSend()) || ($model->passExam->passExamProtocol && $model->passExam->passExamProtocol->countFilesSend())) && is_null($model->passExam->agree) ? Html::a('Я согласен с результатами проведения аттестационной комиссии',['transfer/default/yes', 'id' => $model->id],['data'=>[ 'confirm' => 'Вы уверены, что Вы согласны с результатами проведения аттестационной комиссии?']]) ."<br/>".
                                    Html::a('Я не согласен с результатами проведения аттестационной комиссии',['transfer/default/no', 'id' => $model->id], ['data'=>[ 'confirm' => 'В связи с пунктом 3.16 Положения об основаниях и порядке перевода, отчисления и восстановления ( с изм.  и доп. утв. ученым советом МПГУ протокол от 25 мая 2020 г. №7) Пересдача аттестационных испытаний не допускается, подача апелляции не предусмотрена. В связи с чем ваш перевод и/или восстановление будет аннулирован”']])  : ''?></p>
                            <?php if($model->isContract() && $model->passExam->isSuccessExam()): ?>
                             <p class="bg-info">
                                 <?php if($model->transferMpgu->type == \modules\transfer\models\TransferMpgu::FROM_EDU): ?>
                                     «Вы успешно прошли аттестационное испытание. На ближайшем заседании Комиссии по переводам и восстановлениям по Вашему переводу будет принято положительное решение, и Отдел переводов и восстановлений сможет выдать Вам справку о переводе, на основании которой Вы сможете написать заявление об отчислении из исходной образовательной организации. <br />
                                     Обращаем Ваше внимание! Заключить догповор об оказании платных образовательных услуг можно только после предоставления документов об отчислении в Отдел переводов и восстановлений. Договор об оказании платных образовательных услуг заключается очно по адресу: Проспект Вернадского, 88, кабинет 546.
                                     Необходимо присутствие обучающегося и заказчика (в случае если обучающийся не является заказчиком). При себе необходимо иметь паспорта. При возникновении вопросов обращаться в отдел договорного приема МПГУ по тел: 8-495-438-18-57, по адресу электронной почты: dg@mpgu.su.»
                                  <?php else: ?>
                                     «Вы успешно прошли аттестационные испытания и можете заключить договор об оказании платных образовательных услуг.<br/>
                                      Договор об оказании платных образовательных услуг заключается <u>очно</u> по адресу: Проспект Вернадского, 88, кабинет 546. Необходимо присутствие обучающегося и заказчика (в случае если обучающийся не является заказчиком).
                                      При себе необходимо иметь паспорта.
                                      При возникновении вопросов обращаться в отдел договорного приема МПГУ по тел: 8-495-438-18-57, по адресу электронной почты: dg@mpgu.su. <br />
                                      ВАЖНО! Для заключения договора необходима заверенная копия заявления. Для её получения необходимо обратиться в Отдел переводов и восстановлений.»
                                 <?php endif; ?>
                             </p>
                            <p><?php /* Html::a("Договор на платное обучение","/transfer/post-document/agreement-contract", ['class'=>'pull-right btn btn-info']) */ ?></p>
                            <?php endif; ?>
                        <?php else: ?>
                         нет данных
                        <?php endif; ?>
                    </td>
                </tr>
             <?php else: ?>
            <tr>
                <td colspan="2" class="bg-warning">Ваши документы приняты и переданы в учебное структурное подразделение.
                    Для получения информации о издании приказа о восстановлении
                    Вы можете обратиться в деканат интересующего Вас факультета/института.
                    С контактной информацией учебных структурных подразделений Вы можете ознакомиться по ссылке:
                    <a href="http://mpgu.su/ob-mpgu/struktru/faculties/">http://mpgu.su/ob-mpgu/struktru/faculties/</a>
                </td>
            </tr>
        <?php endif ?>
    <?php if ($agreement = $model->statementAgreement): ?>
        <tr>
            <td colspan="2">Договор об оказании платных образовательных услуг</td>
        </tr>
            <tr>
                <td>
                    <?= $agreement->statementTransfer->cg ? $agreement->statementTransfer->cg->fullNameCg  : ""  ?>
                    <?php if($agreement->message && $agreement->statusNoAccepted()): ?>
                        <br/> Причина отклонения: <?= $agreement->message ?>
                    <?php endif; ?>
                </td>
                <td>
                         <span class="label label-<?= ContractHelper::colorAgreementList()[$agreement->status_id] ?>">
                        <?= $agreement->statusNameStudent ?></span>

                </td>
            </tr>
            <?php if ($agreement->statusGroupAccepted() && $agreement->receiptContract): ?>
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