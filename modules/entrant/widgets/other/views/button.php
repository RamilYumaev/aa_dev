<?php

use backend\widgets\adminlte\Box;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userId  integer */
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */
?>

<?= Html::a("Преимущественное право", ['default/preemptive-right', "user_id" => $userId], ["class" => "btn btn-warning"]) ?>
