<?php
/* @var $this yii\web\View */

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $files yii\db\BaseActiveRecord */
/* @var $file modules\transfer\models\File */
/* @var $link string */
/* @var $id integer */
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */
$jobEntrant = Yii::$app->user->identity->jobEntrant();

?>

<?php Box::begin(
    [
        "header" => "Сканы",
        "type" => Box::TYPE_INFO,
        ]) ?>

<table class="table">
    <?php foreach ($files as $key => $file): ?>
    <tr>
        <td>Файл <?= ++$key ?></td>
        <td><?= Html::a("Скачать", ["/transfer/file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-info"]) ?></td>
        <td><?= Html::a("Принять", ["/transfer/file/accepted",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-success",
                'data-method' => 'post']) ?></td>
        <td><?=  Html::a("Возврат", ["/transfer/file/return",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-warning",
                'data-method' => 'post']) ?></td>
        <td><?= Html::a("Отклонить", ["/transfer/file/message", "hash" => $file->modelHash, 'id' => $file->id], ["class" => "btn btn-danger",
            'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения']) ?></td>
        <td><span class="label label-<?= FileHelper::colorName($file->status)?>"><?=$file->statusName?></span></td>
        <td>Дата создания <?= Yii::$app->formatter->asDatetime($file->created_at) ?> </td>
        <td>Дата обновления <?= Yii::$app->formatter->asDatetime($file->updated_at) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php Box::end(); ?>

<?php
$this->registerJs("
if (window.location.hash!='') {
    window.hashName = window.location.hash;
    window.location.hash = '';
    $(document).ready(function() {
        $('html').animate({scrollTop: $(window.hashName).offset().top}, 2000, function() {
            window.location.hash = window.hashName;
        });
    });
}", View::POS_READY);


?>