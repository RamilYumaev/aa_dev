<?php

/* @var $this yii\web\View */
/* @var $model dictionary\forms\FacultyForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Факультеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
