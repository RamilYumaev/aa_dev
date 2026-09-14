
<?php

use modules\transfer\models\TransferSetting;
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model TransferSetting */

$this->title = 'Создать настройки ПиВо';
$this->params['breadcrumbs'][] = [
    'label' => 'Transfer Settings',
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transfer-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
