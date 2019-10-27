<?php

/* @var $this yii\web\View */
/* @var $faculty dictionary\models\Faculty */
/* @var $model dictionary\forms\FacultyForm */

$this->title = 'Обновить факультет: ' . $faculty->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Факультеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $faculty->full_name, 'url' => ['view', 'id' => $faculty->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="faculty-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
