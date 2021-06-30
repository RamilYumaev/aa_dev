<?php
use modules\entrant\helpers\StatementHelper;

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
                    <?= '<span class="label label-' .($model->passExam->isPassYes() ? 'success' : 'danger').'">'.($model->passExam->isPassYes() ? 'Допущен' : 'Недопущен').'</span>'; ?>
                    <p> <?= $model->passExam->isPassNo() ? $model->passExam->message : ""?></p>
                <?php else: ?>
                 нет данных
                <?php endif; ?>
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php endif; ?>

