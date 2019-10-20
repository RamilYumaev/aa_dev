<?php

/* @var $this yii\web\View */
/* @var $model common\forms\dictionary\FacultyForm */

$this->title = 'Create Faculty';
$this->params['breadcrumbs'][] = ['label' => 'Faculty', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
