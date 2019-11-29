<?php
use backend\widgets\adminlte\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;

/* @var $searchModel testing\forms\question\search\QuestionSearch */
$this->title = "с загрузкой файла";
?>
<?= $this->render('@backend/views/testing/question/_questions-type-link', ['olympic' => $olympic_id]) ?>
<?= $this->render('@backend/views/testing/question/_girdview', ['olympic_id' => $olympic_id, 'dataProvider' => $dataProvider,
    'searchModel' => $searchModel]) ?>