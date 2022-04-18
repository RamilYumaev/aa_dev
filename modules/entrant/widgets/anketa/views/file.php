<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $anketa modules\entrant\models\Anketa */
?>
<table class="table table-bordered">
    <tr>
        <th>Страница паспорта гражданина РФ с отметкой о пересечении границы РФ, миграционная карта или иной документ </th>
        <th><?= FileWidget::widget(['record_id' => $anketa->id, 'model' =>$anketa::className() ]) ?></th>
    </tr>
    <tr class="<?= BlockRedGreenHelper::colorTableBg($anketa->countFiles(), FileHelper::listCountModels()[$anketa::className()], true) ?>">

        <td colspan="2">
            <?= FileListWidget::widget(['record_id' => $anketa->id, 'model' => $anketa::className(),  'userId' => $anketa->user_id]) ?>
        </td>
    </tr>

</table>