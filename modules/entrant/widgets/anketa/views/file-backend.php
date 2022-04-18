<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;

?>
<?php if($anketa) { Box::begin(
    [
        "header" => "Докуменнт",
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
<table class="table table-bordered">
    <tr>
        <th>Страница паспорта гражданина РФ с отметкой о пересечении границы РФ, миграционная карта или иной документ</th>
    </tr>
</table>

<?= \modules\entrant\widgets\file\FileListBackendWidget::Widget([ 'view'=>'list-backend',
    'record_id' => $anketa->id,
    'model' => $anketa::className(),
    'userId' => $anketa->user_id]) ?>
<?php Box::end(); } ?>