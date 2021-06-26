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
</table>
<?php endif; ?>

