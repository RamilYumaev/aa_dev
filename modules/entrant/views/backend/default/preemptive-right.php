<?php
/* @var $this yii\web\View */
use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;
/* @var $profile olympic\models\auth\Profiles */
ModalAsset::register($this);
$userId = $profile->user_id;

$this->title = 'Преимущественное право';
$this->params['breadcrumbs'][] = ['label' => 'Абитуриенты', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => $profile->getFio() .'. Персональная карточка поступающего',
    'url' => ['default/full', 'user'=>$userId]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= \modules\entrant\widgets\other\PreemptiveRightIndexWidget::widget(['userId' => $userId, 'view' => 'preemptive-right-mpgu']) ?>