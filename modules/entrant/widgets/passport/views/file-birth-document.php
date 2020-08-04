<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $model modules\entrant\models\PassportData*/
?>
<?php if($model) : ?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Скан свидетельства о рождении</h4></div>
    <div class="panel-body">
        <p class="label label-warning fs-15">Необходимо загрузить 1 файл</p>
        <table class="table table-bordered">
            <tr>
                <th>Свидетельство о рождении</th>
                <th>Тип</th>
                <th><?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?></th>
            </tr>
            <tr class="<?= BlockRedGreenHelper::colorTableBg($model->countFiles(), FileHelper::listCountModels()[$model::className()]) ?>">
                <td>
                    <?= $model->passportFull ?>
                </td>
                <td>
                    <?= $model->typeName ?>
                </td>
                <td>

                </td>
            </tr>
        </table>
        <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>
    </div>
</div>
<?php endif;?>
