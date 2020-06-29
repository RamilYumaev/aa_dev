<?php
/* @var $this yii\web\View */
use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;
/* @var $profile olympic\models\auth\Profiles */
ModalAsset::register($this);

$this->title = 'Преимущественное право';
$this->params['breadcrumbs'][] = ['label' => 'Абитуриенты', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => $profile->getFio() .'. Персональная карточка поступающего', 'url' => ['default/full']];
$this->params['breadcrumbs'][] = $this->title;

$userId = $profile->user_id;
?>
<?= \modules\entrant\widgets\other\PreemptiveRightIndexWidget::widget(['userId' => $userId, 'view' => 'preemptive-right-mpgu']) ?>