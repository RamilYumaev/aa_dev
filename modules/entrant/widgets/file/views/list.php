<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

/* @var $files yii\db\BaseActiveRecord */
/* @var $file modules\entrant\models\File */
/* @var $id integer */


?>
<table class="table">
    <?php foreach ($files as $key => $file): ?>
    <tr>
        <td>Страница <?= ++$key ?></td>
        <td><?= Html::a("Скачать", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-info"]) ?></td>
        <td><?= Html::a("Обновить", ["file/update", "hash" => $file->modelHash, 'id' => $file->id ], ["class" => "btn btn-primary",
                'data-pjax' => 'w0', 'data-toggle' => 'modal',
                'data-target' => '#modal', 'data-modalTitle' => 'Обновить']) ?></td>
        <td><?= Html::a("Удалить", ["file/delete",'id' => $file->id, "hash" => $file->modelHash ],
                ["class" => "btn btn-danger", 'data-method' => 'post', 'data-confirm' => 'Вы уверены, что хотите удалить файл?']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

