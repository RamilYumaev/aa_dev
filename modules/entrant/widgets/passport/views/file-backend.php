<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $statement modules\entrant\models\Statement*/
/* @var $model modules\entrant\models\PassportData*/
?>

<h3>Скан документа, удостоверяющего личность</h3>
<table class="table table-bordered">
    <tr>
        <th>Документ, удостоверяющий личность</th>
        <th>Тип</th>
    </tr>
    <tr>
        <td>
            <?= $model->passportFull ?>
        </td>
        <td>
            <?= $model->typeName ?>
        </td>
    </tr>
    <tr>
        <?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>
    </tr>

</table>