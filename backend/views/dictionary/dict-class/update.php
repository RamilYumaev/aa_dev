<?php

/* @var $this yii\web\View */
/* @var $class dictionary\models\DictClass */
/* @var $model dictionary\forms\DictClassForm */

$this->title = 'Обновить: ' . $class->name;
$this->params['breadcrumbs'][] = ['label' => 'Курсы/class', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $class->name, 'url' => ['view', 'id' => $class->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
