<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\modules\ones\model\CompetitiveGroupOnes*/
$this->title = "Конкурсные списки. Добавление ";
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные списки', 'url' => ['competitive-list/index']];

$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

