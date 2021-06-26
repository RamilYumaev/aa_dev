<?php
/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles*/
/* @var $transfer modules\transfer\models\TransferMpgu*/

use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

ModalAsset::register($this);

$this->title = 'Документы';

$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['profiles/index']];
$this->params['breadcrumbs'][] = ['label' => $profile->fio, 'url' => ['profiles/view', 'id' => $transfer->id]];
$this->params['breadcrumbs'][] = $this->title;

$anketa = $profile->anketa;
$userId = $profile->user_id;
?>
<div class="row">
        <div class="col-md-12">
            <?= Html::a("Сообщить об ошибке", ['send-error', 'user' => $transfer->id], [
                    'class' => 'btn btn-danger',
                'data' => ['method'=>'post', 'confirm'=> "Вы уверены что хотите отправить письмо?"]]) ?>
            <?= \modules\transfer\widgets\passport\PassportMainWidget::widget(['view' => 'file-backend', 'userId' => $userId]); ?>
            <?= \modules\transfer\widgets\address\AddressFileWidget::widget(['view' => 'file-backend', 'userId' => $userId]); ?>
            <?= \modules\transfer\widgets\insurance\InsuranceWidget::widget([ 'view' => 'file-backend', 'userId' => $userId]); ?>
            <?= \modules\transfer\widgets\statement\StatementPersonalDataWidget::widget(['view' => 'index-pd-backend', 'userId' => $userId]); ?>
        </div>
    </div>
