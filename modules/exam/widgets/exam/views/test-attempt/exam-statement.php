<?php

use modules\exam\models\ExamAttempt;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box box-primary">
    <div class="box box-header">
        <h4>Попытка</h4>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'start:datetime',
                'end:datetime',
                ['value' => function(ExamAttempt $model) {
                  if($model->isAttemptEnd()) {
                      return '';
                  } elseif($model->isAttemptPause()) {
                      return Html::a("Возобновить",['exam-attempt/start-attempt', 'id' =>$model->id], ['class'=> 'btn btn-success']);
                  }
                  else {
                      return Html::a("Остановить",['exam-attempt/pause-attempt',  'id' =>$model->id], ['class'=> 'btn btn-warning']);
                  }

                }, 'format'=>'raw']
            ],
        ]) ?>
    </div>
</div>

