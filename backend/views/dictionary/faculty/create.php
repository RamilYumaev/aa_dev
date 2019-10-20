<?php

/* @var $this yii\web\View */
/* @var $model common\forms\dictionary\FacultyForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Faculty', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-create">

    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
