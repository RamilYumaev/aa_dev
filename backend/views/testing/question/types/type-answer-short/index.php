<?php

/* @var $searchModel testing\forms\question\search\QuestionSearch */

$this->title = "с коротким ответом";
?>
<?= $this->render('@backend/views/testing/question/_questions-type-link', ['olympic' => $olympic_id]) ?>
<?= $this->render('@backend/views/testing/question/_girdview', ['olympic_id' => $olympic_id, 'dataProvider' => $dataProvider,
    'searchModel' => $searchModel]) ?>