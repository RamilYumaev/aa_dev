<?php

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones\model\OrderTransferOnes */
$this->title = "Приказы. Редактирование.";
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Приказы', 'url' => ['order-transfer/index']];
$this->params['breadcrumbs'][] = $this->title;
$model->education_level = json_decode($model->education_level, true);
$model->type_competitive = json_decode($model->type_competitive, true);
?>
<?= $this->render('_form', ['model'=> $model])?>
