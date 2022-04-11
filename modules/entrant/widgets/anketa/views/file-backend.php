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
        <th>Гражданин РФ, который до прибытия на территорию Российской Федерации проживал на территории ДНР, ЛНР </th>
    </tr>
</table>

<?= \modules\entrant\widgets\file\FileListBackendWidget::Widget([ 'view'=>'list-backend',
    'record_id' => $anketa->id,
    'model' => $anketa::className(),
    'userId' => $anketa->user_id]) ?>
<?php Box::end(); } ?>