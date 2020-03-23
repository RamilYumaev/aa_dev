<?php
/* @var $this yii\web\View */
/* @var $model modules\dictionary\forms\DictPostEducationForm */
$this->title = "Категории граждан. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Категории граждан', 'url' => ['dict-post-category/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

