<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $results \yii\db\ActiveRecord */
/* @var $result \modules\exam\models\ExamResult */
/* @var $url */

?>
<div class="box box-default">
    <?php foreach($results as $result) : ?>
       <?= Html::a($result->priority,
            [$url, 'id'=> $result->attempt->test_id, 'page' => $result->priority],
            ['class'=> $result->priority == Yii::$app->request->get("page") ? 'btn btn-primary' : ($result->result ?'btn btn-warning': 'btn btn-default')]) ?>
    <?php endforeach; ?>
</div>

