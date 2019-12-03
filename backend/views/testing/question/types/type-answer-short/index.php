<?php

/* @var $searchModel testing\forms\question\search\QuestionSearch */
/* @var $olympic_id int */
$this->title = "Краткий ответ";
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@backend/views/testing/question/_questions-type-link', ['olympic' => $olympic_id]) ?>
<?= $this->render('@backend/views/testing/question/_girdview', ['olympic_id' => $olympic_id, 'dataProvider' => $dataProvider,
    'searchModel' => $searchModel]) ?>