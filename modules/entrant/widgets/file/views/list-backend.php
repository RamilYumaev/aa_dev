<?php
/* @var $this yii\web\View */

use backend\widgets\adminlte\Box;
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
        <td><?= Html::a("Принять", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-success"]) ?></td>
        <td><?= Html::a("Отклонить", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-danger"]) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php Box::end(); ?>
