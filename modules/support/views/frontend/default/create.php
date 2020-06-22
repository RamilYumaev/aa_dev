<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/akiraz2/yii2-ticket-support
 * @copyright 2018 akiraz2
 * @license MIT
 */

/* @var $this yii\web\View */
/* @var $model modules\support\models\Ticket */


/* breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => \modules\support\ModuleFrontend::t('support', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\modules\support\assets\TicketAsset::register($this);

?>
<div class="ticket-create">
    <div class="box box-success">
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
