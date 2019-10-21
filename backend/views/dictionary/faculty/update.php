<?php

/* @var $this yii\web\View */
/* @var $faculty common\models\dictionary\Faculty */
/* @var $model common\forms\dictionary\FacultyForm */

$this->title = 'Обновить факультет: ' . $faculty->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Факультеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $faculty->full_name, 'url' => ['view', 'id' => $faculty->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="faculty-update">
    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
