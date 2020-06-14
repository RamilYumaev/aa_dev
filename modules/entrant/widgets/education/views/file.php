<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $model modules\entrant\models\DocumentEducation*/
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Скан документа об образовании</h4></div>
    <div class="panel-body">
        <p class="label label-danger">Необходимо загрузить страницу с ФИО, серией и номером документа. А также отдельно загрузить вкладыш с оценками</p>
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
                </td>
            </tr>
        </table>
        <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>
    </div>
</div>