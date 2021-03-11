<?php

/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\VolunteeringForm */
/* @var $entity \modules\dictionary\models\Volunteering */
$this->title = "Волонтер. ". $entity->entrantJob->profileUser->fio;
$this->params['breadcrumbs'][] = ['label' => 'Волонтеры', 'url' => ['volunteering/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model] )?>
