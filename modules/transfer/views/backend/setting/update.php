<?php

use modules\transfer\models\TransferSetting;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model TransferSetting */

$this->title = 'Редактировать настройки ПиВо #' . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Transfer Settings',
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url' => ['view', 'id' => $model->id],
];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="transfer-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
