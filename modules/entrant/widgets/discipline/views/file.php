<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $all \yii\db\ActiveQuery */
/* @var $model modules\entrant\models\UserDiscipline */
?>
    <h3>Централизованное тестирование</h3>
<table class="table table-bordered">
    <tr>
        <th>Предметы</th>
        <th></th>
    </tr>
    <?php foreach ($all as $model): ?>
    <tr class="<?= BlockRedGreenHelper::colorTableBg($model->countFiles(), FileHelper::listCountModels()[$model::className()], true) ?>">
        <td>
            <?= $model->dictDisciplineSelect->ct->name ?>
        </td>
        <td><?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(),  'userId' => $model->user_id]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>