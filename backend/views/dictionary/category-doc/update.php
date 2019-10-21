<?php

/* @var $this yii\web\View */
/* @var $catDoc common\models\dictionary\CategoryDoc */
/* @var $model common\forms\dictionary\CategoryDocForm */

$this->title = 'Обновить: ' . $catDoc->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории документов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $catDoc->name, 'url' => ['view', 'id' => $catDoc->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="сatDoc-update">
    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
