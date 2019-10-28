<?php

/* @var $this yii\web\View */
/* @var $discipline dictionary\models\DictDiscipline */
/* @var $model dictionary\forms\DictDisciplineForm */

$this->title = 'Обновить: ' . $discipline->name;
$this->params['breadcrumbs'][] = ['label' => 'Дисциплины', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $discipline->name, 'url' => ['view', 'id' => $discipline->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
