<?php
/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $agreement modules\entrant\models\Agreement */

use entrant\assets\modal\ModalAsset;
ModalAsset::register($this);


$this->title = $agreement->profile->fio ." ". $agreement->organization->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['view' => 'file-backend', 'userId' => $agreement->user_id]); ?>
