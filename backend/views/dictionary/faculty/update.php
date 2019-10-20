<?php

/* @var $this yii\web\View */
/* @var $faculty common\models\dictionary\Faculty */
/* @var $model common\forms\dictionary\FacultyForm */

$this->title = 'Update Faculty: ' . $faculty->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Faculty', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $faculty->full_name, 'url' => ['view', 'id' => $faculty->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faculty-update">
    <h1><?= $this->title ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
