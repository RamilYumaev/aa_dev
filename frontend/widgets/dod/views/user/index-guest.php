<?php
use yii\helpers\Html;
/* @var  $dod dod\models\DateDod */
$class= 'btn btn-lg btn-bd-primary mb-3 mb-md-0 mr-md-3';
?>
<div>
    <center>
        <?php if ($dod->isTypeHybrid()) : ?>
            <?= Html::a('Зарегистрироваться', ['registration-on-dod', 'id' => $dod->id], ['class' => $class]); ?>
            <?= Html::a('Онлайн участие', ['dod', 'id' => $dod->id], ['class' => $class]); ?>
        <?php elseif ($dod->isTypeRemote()) : ?>
            <?= Html::a('Онлайн участие', ['dod', 'id' => $dod->id], ['class' => $class]); ?>
        <?php else: ?>
            <?= Html::a('Зарегистрироваться', ['registration-on-dod', 'id' => $dod->id], ['class' => $class]); ?>
        <?php endif;?>
    </center>
</div>


