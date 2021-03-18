<?php
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $task modules\management\models\Task */
/* @var $document modules\management\models\DocumentTask */

?>
<?php foreach ($task->getDocuments()->all() as $document):
    $url =$document->registryDocument->link ? $document->registryDocument->link : $document->registryDocument->getUploadedFileUrl('file');
    ?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6"><?= Html::a($document->registryDocument->name, $url)?></div>
                <div class="col-md-3"><?= $document->registryDocument->accessName ?></div>
                <div class="col-md-3"><?= Html::a("Скачать", $url, ['class' => 'btn btn-info', ' download'=> true] )?></div>
            </div>
        </div>
<?php endforeach; ?>


