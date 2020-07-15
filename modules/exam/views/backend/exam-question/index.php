<?php
/* @var $searchModel testing\forms\question\search\QuestionSearch */
/* @var  $olympic_id int*/

$this->title = "Вопросы";
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_questions-type-link') ?>
<?= $this->render('_girdview', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]) ?>