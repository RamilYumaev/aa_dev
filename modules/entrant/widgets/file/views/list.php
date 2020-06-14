<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;

/* @var $files yii\db\BaseActiveRecord */
/* @var $file modules\entrant\models\File */
/* @var $id integer */


?>
<table class="table table-bordered" style="background-color: transparent">
    <?php foreach ($files as $key => $file): ?>
    <?php if($file->message): ?>
        <tr>
            <td><?= $file->message ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>Файл <?= ++$key ?></td>
        <td><?= Html::a("Скачать", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-info"]) ?></td>
        <td>
            <?= !$file->isAcceptedStatus() ? Html::a("Обновить", ["file/update", "hash" => $file->modelHash, 'id' => $file->id ], ["class" => "btn btn-primary",
                'data-pjax' => 'w0', 'data-toggle' => 'modal',
                'data-target' => '#modal', 'data-modalTitle' => 'Обновить']) : "" ?></td>
        <td><?= $file->isDraftStatus() ? Html::a("Удалить", ["file/delete",'id' => $file->id, "hash" => $file->modelHash ],
                ["class" => "btn btn-danger", 'data-method' => 'post', 'data-confirm' => 'Вы уверены, что хотите удалить файл?']) :"" ?></td>
    <td><span class="label label-<?= FileHelper::colorName($file->status)?>"><?=$file->statusName?></span></td></tr>
    <?php endforeach; ?>
</table>

