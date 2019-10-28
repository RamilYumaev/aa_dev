<?php

/* @var $this yii\web\View */
/* @var $model dictionary\forms\DictDisciplineForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Дисциплины', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
