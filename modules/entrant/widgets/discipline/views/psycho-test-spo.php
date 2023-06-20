<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $all \yii\db\ActiveQuery */
/* @var $model modules\entrant\models\PsychoTestSpo */
?>
<?php if($model) :?>
    <h3>Психологическое тестирование</h3>
    <table class="table table-bordered">
        <tr class="<?= BlockRedGreenHelper::colorTableBg($model->countFiles(), FileHelper::listCountModels()[$model::className()], true) ?>">
            <td>
                <a class="btn btn-warning" href="<?= \yii\helpers\Url::to('/instructions/psy_test.docx')?>" download>Скачать</a>
            </td>
            <td><?= FileWidget::widget(['record_id' => $model->id, 'model' => $model::className() ]) ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(),  'userId' => $model->user_id]) ?>
            </td>
        </tr>
    </table>
<?php endif; ?>