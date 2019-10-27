<?php

/* @var $this yii\web\View */
/* @var $catDoc dictionary\models\CategoryDoc */
/* @var $model dictionary\forms\CategoryDocForm */

$this->title = 'Обновить: ' . $catDoc->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории документов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $catDoc->name, 'url' => ['view', 'id' => $catDoc->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
