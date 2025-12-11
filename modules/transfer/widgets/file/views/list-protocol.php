<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;

/* @var $files yii\db\BaseActiveRecord */
/* @var $file modules\transfer\models\File */
/* @var $id integer */

/* @var $job \modules\dictionary\models\JobEntrant */
$job = Yii::$app->user->identity->jobEntrant();

?>
<table class="table table-bordered" style="background-color: transparent">
    <?php foreach ($files as $key => $file): ?>
    <?php if($file->message): ?>
        <tr>
            <td class="danger" colspan="5"><h5 class="bg-danger"><?= $file->message ?></h5></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td>Файл <?= ++$key ?></td>
        <td><?= Html::a("Скачать", ["/transfer/file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-info"]) ?></td>
        <td>
        <?= Html::a("Обновить", ["file/update", "hash" => $file->modelHash, 'id' => $file->id ], ["class" => "btn btn-primary",
                'data-pjax' => 'w0', 'data-toggle' => 'modal',
                'data-target' => '#modal', 'data-modalTitle' => 'Обновить']) ?></td>
        <?php if ($job->isAgreement()) :?>
        <td><?= Html::a("Принять", ["/transfer/file/accepted",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-success",
                'data-method' => 'post']) ?></td>
        <td><?= Html::a("Отклонить", ["/transfer/file/message", "hash" => $file->modelHash, 'id' => $file->id], ["class" => "btn btn-danger",
                'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения']) ?></td>
        <?php endif; ?>
        <td><span class="label label-<?=  FileHelper::colorName($file->status)?>"><?=$file->statusName?></span></td></tr>
    <?php endforeach; ?>
</table>

