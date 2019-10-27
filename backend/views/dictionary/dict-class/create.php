<?php

/* @var $this yii\web\View */
/* @var $model dictionary\forms\DictClassForm */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Классы\курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
