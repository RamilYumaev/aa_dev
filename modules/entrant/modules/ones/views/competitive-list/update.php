<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones\model\CompetitiveList */
$this->title = "Конкурсные списки. Редактирование. " .$model->fio." ".$model->snils_or_id;;
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсная группа '.$model->competitiveGroup->name, 'url' => ['default/view', 'id'=> $model->cg_id]];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competitive-list/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model])?>
