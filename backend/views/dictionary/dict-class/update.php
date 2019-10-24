<?php

/* @var $this yii\web\View */
/* @var $catDoc common\models\dictionary\CategoryDoc */
/* @var $model common\forms\dictionary\CategoryDocForm */

$this->title = 'Обновить: ' . $class->name;
$this->params['breadcrumbs'][] = ['label' => 'Курсы/class', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $class->name, 'url' => ['view', 'id' => $class->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="class-update">
    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
