<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;

/* @var $model modules\entrant\models\InsuranceCertificateUser */
?>
<?php if($model): ?>
    <h4>Требования к документу СНИЛС:</h4>
    <p align="justify"> необходимо загрузить подтверждающий скан (скан карточки или скриншот из личного кабинета)</p>
        <h3>СНИЛС</h3>
    <table class="table table-bordered">
        <tr>
            <th>Данные</th>
            <th><?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?></th>
        </tr>
        <tr class="<?= BlockRedGreenHelper::colorTableBg($model->countTransferFiles(), FileHelper::listCountModels()[$model::className()], true) ?>">
            <td>
                <?= $model->number ?>
            </td>
            <td>
                <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(),  'userId' => $model->user_id]) ?>
            </td>
        </tr>

    </table>
<?php endif; ?>