<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $olympic  olympic\models\OlimpicList */
/* @var  $userOlympic olympic\models\UserOlimpiads*/
\frontend\assets\modal\ModalAsset::register($this);
?>
<?php if(!$userOlympic): ?>
    <?= Html::a('Записаться', ['user-olympic/registration', 'id' => $olympic->id],
        ['class' => 'btn btn-primary btn-lg']) ?>
<?php else: ?>
    <?php  $class= \common\auth\helpers\UserSchoolHelper::userClassId(\Yii::$app->user->identity->getId(), \common\helpers\EduYearHelper::eduYear());
    $test = \testing\helpers\TestHelper::testAndClassActiveOlympicList($userOlympic->olympiads_id, $class);  ?>
    <?= $test ? Html::a('Начать заочный тур', ['/test/start','id' => $test],
        ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle'
        =>'Заочный тур', 'class'=>'btn btn-primary btn-lg']): "" ?>
    <?= Html::a('Отменить запись', ['user-olympic/delete', 'id' => $userOlympic->id],
        ['class' => 'btn btn-primary btn-lg',
            'data' => ['confirm' => 'Вы действительно хотите отменить запись ?', 'method' => 'POST']]); ?>
<?php endif; ?>

<?php Modal::begin(['id'=>'modal', 'size'=> Modal::SIZE_LARGE, 'header' => "<h4 id='header-h4'></h4>", 'clientOptions' => ['backdrop' => false]]);
echo "<div id='modalContent'></div>";
Modal::end()?>

