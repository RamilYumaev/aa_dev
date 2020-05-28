<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

/* @var $files yii\db\BaseActiveRecord */
/* @var $file modules\entrant\models\File */
/* @var $id integer */


?>
<table class="table table-bordered">
    <?php foreach ($files as $key => $file): ?>
    <tr>
        <td>Страница <?= ++$key ?></td>
        <td><?= Html::a("Скачать", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-info"]) ?></td>
        <td><?= Html::a("Принять", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-success"]) ?></td>
        <td><?= Html::a("Отклонить", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-danger"]) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

