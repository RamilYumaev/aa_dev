<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\modules\ones\model\OrderTransferOnes*/
$this->title = "Приказ. Добавление ";
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Приказы', 'url' => ['order-transfer/index']];

$this->params['breadcrumbs'][] = $this->title;


?>
<?= $this->render('_form', ['model'=> $model] )?>

