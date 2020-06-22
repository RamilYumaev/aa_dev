<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/akiraz2/yii2-ticket-support
 * @copyright 2018 akiraz2
 * @license MIT
 */

/* @var $this yii\web\View */
/* @var $model \modules\support\models\Content */
?>

<?= \modules\support\ModuleFrontend::t('support', 'Ticket #{ID}: New reply from {NAME}:', [
    'ID' => $model->ticket->id,
    'NAME' => !empty($model->user_id) ? $model->user->{\Yii::$app->getModule('support')->userName} : \modules\support\ModuleFrontend::t('support',
        'Ticket System')
]) ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>


<?= \modules\support\ModuleFrontend::t('support', 'View Ticket: {URL}', ['URL' => $model->ticket->getUrl(true)]) ?>