<?php

use modules\exam\models\ExamAttempt;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $markShow bool */

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
                $markShow ? 'mark' : 'end:datetime',
                ['value' => function(ExamAttempt $model) use($markShow) {
                  if (!$markShow) {
                      if($model->isAttemptEnd()) {
                          return '';
                      } elseif($model->isAttemptPause()) {
                          return Html::a("Возобновить",['exam-attempt/start-attempt', 'id' =>$model->id], ['class'=> 'btn btn-success']);
                      }
                      else {
                          return Html::a("Остановить",['exam-attempt/pause-attempt',  'id' =>$model->id], ['class'=> 'btn btn-warning']);
                      }
                  }

                }, 'format'=>'raw']
            ],
        ]) ?>
    </div>
</div>

