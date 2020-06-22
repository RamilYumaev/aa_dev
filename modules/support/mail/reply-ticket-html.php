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
<?= \modules\support\ModuleFrontend::t('support',
    'Ticket #{ID}: New reply from {NAME}:', [
        'ID' => $model->ticket->hash_id,
        'NAME' => $model->getUsername()
    ]) ?>
<br>
<?= Yii::$app->formatter->asHtml($model->content) ?>
