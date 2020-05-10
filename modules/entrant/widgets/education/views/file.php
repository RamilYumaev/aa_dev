<?php
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $model modules\entrant\models\DocumentEducation*/
?>
<table class="table table-bordered">
    <tr>
        <th>Данные документа об образавании</th>
        <th><?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?></th>
    </tr>
    <tr>
        <td>
            <?= $model->documentFull ?>, <?= $model->schoolName ?>, <?= $model->school->countryRegion ?>
        </td>
        <td>
            <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className()]) ?>
        </td>
    </tr>

</table>