<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $model modules\entrant\models\DocumentEducation*/
?>
<h3>Скан документа об образовании</h3>
<table class="table table-bordered">
    <tr>
        <th>Документ об образовании</th>
        <th>Тип</th>
        <th><?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?></th>
    </tr>
    <tr class="<?= BlockRedGreenHelper::colorTableBg($model->countFiles(), FileHelper::listCountModels()[$model::className()], true)?>">
        <td>
            <?= $model->documentFull ?>, <?= $model->schoolName ?>, <?= $model->school->countryRegion ?>
        </td>
        <td>
            <?= $model->typeName ?>
        </td>
        <td>
            <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>
        </td>
    </tr>

</table>