<?php

/* @var $this yii\web\View */
/* @var $school dictionary\models\DictSchools */
/* @var $model dictionary\forms\DictSchoolsForm */

$this->title = 'Обновить: ' . $school->name;
$this->params['breadcrumbs'][] = ['label' => 'Курсы/class', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $school->name, 'url' => ['view', 'id' => $school->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="class-update">
    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
