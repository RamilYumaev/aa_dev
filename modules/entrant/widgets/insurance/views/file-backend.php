<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;

?>
<?php Box::begin(
    [
        "header" => "СНИЛС",
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
<table class="table table-bordered">
    <tr>
        <th>Данные</th>
    </tr>
    <tr>
        <td>
            <?= $model->number ?>
        </td>
        <td>
            <?= Html::a("Принять", ['communication/export-data-organization', 'agreementId' => $model->id], ['data-method' => 'post', 'class' => 'btn btn-success'])?>
        </td>
        <td>
            <?= Html::a("Отклонить", ["agreement/message",  'id' => $model->id], ["class" => "btn btn-danger",
                'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения']) ?></td>

        </td>
    </tr>
</table>

<?= \modules\entrant\widgets\file\FileListBackendWidget::Widget([ 'view'=>'list-backend',
    'record_id' => $model->id,
    'model' => $model::className(),
    'userId' => $model->user_id]) ?>
<?php Box::end(); ?>

<?php if($model->statement): ?>
    <?php foreach ($model->statement as $statement): ?>
    <?= \modules\entrant\widgets\statement\StatementBackendWidget::widget(['statement' => $statement]) ?>

<?php endforeach; endif; ?>
