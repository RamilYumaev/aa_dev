<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model olympic\forms\WebConferenceForm */
/* @var $web olympic\models\WebConference */
/* @var $webs yii\db\ActiveRecord */

$this->title = 'Вебинары';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach ($webs as $web):?>
    <?= Html::beginTag('h4') ?>
    <?= Html::a($web->name, $web->link) ?>
    <?= Html::endTag('h4') ?>
<?php endforeach;?>
