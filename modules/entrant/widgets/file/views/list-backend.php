<?php
/* @var $this yii\web\View */

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;

/* @var $files yii\db\BaseActiveRecord */
/* @var $file modules\entrant\models\File */
/* @var $id integer */


?>
<?php Box::begin(
    [
        "header" => "Сканы",
        "type" => Box::TYPE_INFO,
        ]) ?>
<table class="table">
    <?php foreach ($files as $key => $file): ?>
    <tr>
        <td>Страница <?= ++$key ?></td>
        <td><?= Html::a("Скачать", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-info"]) ?></td>
        <td><?= Html::a("Принять", ["file/accepted",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-success",
                'data-method' => 'post', 'data-confirm' => 'Вы уверены, что хотите приять файл?']) ?></td>
       <td><?= Html::a("Отклонить", ["file/message", "hash" => $file->modelHash, 'id' => $file->id], ["class" => "btn btn-danger",
            'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения']) ?></td>
        <td><span class="label label-<?= FileHelper::colorName($file->status)?>"><?=$file->statusName?></span></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php Box::end(); ?>
