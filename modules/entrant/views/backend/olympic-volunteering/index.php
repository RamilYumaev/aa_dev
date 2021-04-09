<?php

/* @var $this yii\web\View */

use testing\helpers\TestHelper;
use yii\helpers\Html;

/* @var $userId */
/* @var $olympics */
/* @var $olympic olympic\models\OlimpicList */

\entrant\assets\modal\ModalAsset::register($this);
$this->title = "Олимпиада для волонтеров";
$this->params['breadcrumbs'][] = $this->title;
?> 
<?php foreach ($olympics as $olympic) : ?>
   <div class="row">
       <div class="col-md-12">
           <div class="box">
               <div class="box-header"><h4><?= $olympic->name ?></h4></div>
               <div class="box-body">
                   <div class="row">
                       <div class="col-md-8">
                           <p><?= $olympic->dateRegStartNameString ?></p>
                           <p><?= $olympic->dateRegEndNameString ?> </p>
                           <p><?= $olympic->timeOfDistantsTourNameString ?></p>
                           <p><?= $olympic->timeStartTourNameString ?></p>
                           <p><?= $olympic->addressNameString ?></p>
                           <p><?= $olympic->timeOfTourNameString ?></p>
                           <?= $olympic->contentString ?>
                       </div>
                       <div class="col-md-4">
                           <?php if($olympic->isOnRegisterOlympic): ?>
                               <?php if(!$userOlympic = \olympic\models\UserOlimpiads::findOne(['olympiads_id' => $olympic->id, 'user_id' => $userId])): ?>
                                   <?= Html::a('Записаться', ['olympic-volunteering/registration', 'id' => $olympic->id],
                                       ['class' => 'btn btn-success']) ?>
                               <?php else: ?>
                                   <?php $test = TestHelper::testActiveOlympicList($olympic->id); ?>
                                   <?= $test ? Html::a('Начать заочный тур', ['olympic-volunteering/start-test','id' => $test],
                                       ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Заочный тур', 'class'=>'btn btn-primary']): "" ?>
                                   <?= Html::a('Отменить запись', ['olympic-volunteering/delete', 'id' => $userOlympic->id],
                                       ['class' => 'btn btn-danger',
                                           'data' => ['confirm' => 'Вы действительно хотите отменить запись?', 'method' => 'POST']]); ?>
                               <?php endif; ?>
                           <?php endif; ?>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
<?php endforeach; ?>
