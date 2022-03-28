<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $literature modules\literature\models\LiteratureOlympic */

$this->title = 'Добавить нового участника';
$this->params['breadcrumbs'][] = ['label' => 'Участники ВОШ по литературе 2022', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="literature-olympic-update">

    <?= $this->render('_form', [
        'model' => $literature,
        'user' => $model
    ]) ?>
</div>
