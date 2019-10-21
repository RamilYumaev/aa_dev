<?php

/* @var $this yii\web\View */
/* @var $model common\forms\dictionary\FacultyForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Категории документов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catDoc-create">

    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
