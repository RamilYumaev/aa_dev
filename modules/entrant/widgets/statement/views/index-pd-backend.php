<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statement modules\entrant\models\StatementConsentPersonalData*/
/* @var $isUserSchool bool */
?>
<?php  Box::begin(
    [
        "header" => "Заявление о согласии на обработку персональных данных",
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
    <p><?= Html::a('Скачать заявление', ['statement-personal-data/pdf', 'id' =>  $statement->id], ['class' => 'btn btn-warning'])?></p>

<?= FileListWidget::widget([ 'view'=> 'list-backend','record_id' => $statement->id, 'model' => \modules\entrant\models\StatementConsentPersonalData::class,  'userId' => $statement->user_id ]) ?>

<?php Box::end(); ?>
