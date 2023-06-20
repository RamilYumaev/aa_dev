<?php

use backend\widgets\adminlte\Box;
use modules\entrant\widgets\file\FileListWidget;

/* @var $all \yii\db\ActiveQuery */
/* @var $model modules\entrant\models\PsychoTestSpo */
?>
<?php if($model) :?>
    <?php Box::begin(
        [
            "header" => "Психологическое тестирование",
            "type" => Box::TYPE_WARNING,
            "filled" => true,])
    ?>
    <?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $model->id, 'model' =>  $model::className(), 'userId' => $model->user_id]) ?>
    <?php Box::end(); ?>
<?php endif; ?>