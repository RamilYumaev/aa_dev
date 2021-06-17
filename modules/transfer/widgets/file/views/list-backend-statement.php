<?php
/* @var $this yii\web\View */

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $files yii\db\BaseActiveRecord */
/* @var $file modules\entrant\models\File */
/* @var $id integer */
/* @var $isCorrect bool */


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
        <td><?= Html::a("Скачать", ["file/get",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-info"]) ?></td>
        <?php Pjax::begin(['id' => 'get-bachelor', 'timeout' => false, 'enablePushState' => false]); ?>
        <?php if(!$jobEntrant->isCategoryCOZ()): ?>
        <td><?= !$isCorrect ? Html::a("Принять", ["file/accepted",'id' => $file->id, "hash" => $file->modelHash ], ["class" => "btn btn-success",
                'data-method' => 'post']): "" ?></td>
       <?php endif; ?>
        <td><?= !$isCorrect ? Html::a("Отклонить", ["file/message", "hash" => $file->modelHash, 'id' => $file->id], ["class" => "btn btn-danger",
            'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения']) : "" ?></td>
        <td><span class="label label-<?= FileHelper::colorName($file->status)?>"><?=$file->statusName?></span></td>
        <?php \yii\widgets\Pjax::end()?>
    </tr>
    <?php endforeach; ?>
</table>

<?php Box::end(); ?>

<?php
$this->registerJs("
            $(document).on('pjax:send', function () {
            const button = $('.btn');
            button.addClass(\"glyphicon-time\");
            button.attr('disabled', 'true');
        })
    ", View::POS_READY);


?>