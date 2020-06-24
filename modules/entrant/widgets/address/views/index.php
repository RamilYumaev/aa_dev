<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\helpers\AddressHelper;

/* @var $this yii\web\View */
/* @var $userId integer */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(AddressHelper::isExits($userId)) ?>">
        <div class="p-30 green-border">
        <h4>Адреса регистрации и проживания:</h4>
            <p> <span class="badge bg-red-light">В этом блоке необходимо обязательно указать фактический адрес Вашего
                    проживания и адрес регистрации (постоянной и/или временной)</span></p>
        <?= Html::a('Добавить', ['address/create'], ['class' => 'btn btn-success mb-10']) ?>
        <?= \yii\grid\GridView::widget([
            'tableOptions' => ['class' => 'table  table-bordered'],
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => 'type', 'value' => 'typeName'],
                ['attribute' => 'country_id', 'value' => 'countryName'],
                ['value' => 'addersFull', 'header' => "Адрес"],
                ['value' => function($model) {
                      $button = "";
                      if (!AddressHelper::isExitsType($model->user_id, AddressHelper::TYPE_ACTUAL))  {
                          $button.= Html::a("Совпадает с фактическим", ['address/copy', 'id'=> $model->id,
                              'type' => AddressHelper::TYPE_ACTUAL], ['class' => "btn btn-info"]);
                      }
                      if (!AddressHelper::isExitsType($model->user_id, AddressHelper::TYPE_RESIDENCE) &&
                          !AddressHelper::isExitsType($model->user_id, AddressHelper::TYPE_REGISTRATION))  {
                         $button.= $model->type != AddressHelper::TYPE_REGISTRATION ? Html::a("Совпадает с временным", ['address/copy', 'id'=> $model->id,
                            'type' => AddressHelper::TYPE_RESIDENCE], ['class' => "btn btn-warning"]): "";
                          $button.= $model->type != AddressHelper::TYPE_RESIDENCE ? Html::a("Совпадает с постоянным", ['address/copy', 'id'=> $model->id,
                              'type' => AddressHelper::TYPE_REGISTRATION], ['class' => "btn btn-success"]) : "";
                      }
                      return $button;
                }, 'format' => "raw"],
                ['class' => \yii\grid\ActionColumn::class, 'controller' => 'address', 'template' => '{update}{delete}']
            ],
        ]) ?>
    </div>
</div>
</div>
