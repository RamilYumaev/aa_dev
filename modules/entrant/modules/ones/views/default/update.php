<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones\model\CompetitiveGroupOnes */
$this->title = "Конкурсная группа. Редактирование. " .$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model])?>
