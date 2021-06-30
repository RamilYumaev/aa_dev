<?php
use modules\entrant\helpers\StatementHelper;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\transfer\models\StatementTransfer */
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
            <td colspan="2">Данные по аттестации:
                <?php if($model->passExam): ?>
                    <?= '<span class="label label-' .($model->passExam->isPassYes() ? 'success' : 'danger').'">'.($model->passExam->isPassYes() ? 'Допущен' : 'Недопущен').'</span>'; ?> <br />
                    <?= is_null($model->passExam->agree) ? "":'<span class="label label-' .($model->passExam->agree == 1 ? 'success' : 'danger').'">'.($model->passExam->agree == 1  ? 'Согласен с результатами проведения аттестационной комиссии' : 'Не согласен с результатами проведения аттестационной комиссии').'</span>'; ?>
                    <p> <?= $model->passExam->isPassNo() ? $model->passExam->message : ""?></p>
                    <?= $model->passExam->countFilesSend() ? FileListWidget::widget(['record_id' => $model->passExam->id,
                        'model' => \modules\transfer\models\PassExam::class, 'userId' => $model->user_id]) : ""?>
                    <p><?= $model->passExam->countFilesSend() && is_null($model->passExam->agree) ? Html::a('Я согласен с результатами проведения аттестационной комиссии',['transfer/default/yes', 'id' => $model->id],['data'=>[ 'confirm' => 'Вы уверены, что Вы согласны с результатами проведения аттестационной комиссии?']]) ."<br/>".
                            Html::a('Я не согласен с результатами проведения аттестационной комиссии',['transfer/default/no', 'id' => $model->id], ['data'=>[ 'confirm' => 'В связи с пунктом 3.16 Положения об основаниях и порядке перевода, отчисления и восстановления ( с изм.  и доп. утв. ученым советом МПГУ протокол от 25 мая 2020 г. №7) Пересдача аттестационных испытаний не допускается, подача апелляции не предусмотрена. В связи с чем ваш перевод и/или восстановление будет аннулирован”']])  : ''?></p>
                <?php else: ?>
                 нет данных
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php endif; ?>

