<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\literature\models\LiteratureOlympic */

$this->title = 'Обновить '. $model->user->profiles->fio;
$this->params['breadcrumbs'][] = ['label' => 'Участники ВОШ по литературе 2022', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->profiles->fio, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title
?>
<div class="literature-olympic-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
