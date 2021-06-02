<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\entrant\helpers\BlockRedGreenHelper;

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $referrer */
$column = [
    'last_name',
    'first_name',
    'patronymic',
    ['label'=>$profile->getAttributeLabel('gender'),
        'value' =>$profile->genderName],
    'phone',
    ['label'=>$profile->getAttributeLabel('country_id'),
        'value' =>$profile->countryName],
    ['label'=>$profile->getAttributeLabel('region_id'),
        'value' =>$profile->regionName],
];
 if($profile->isNoRussia()) {
     array_pop($column);
 }
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($profile->isDataNoEmpty()) ?>">
        <div class="p-30 green-border">
        <h4>Профиль</h4>
        <?= Html::a('Редактировать', ['/profile/edit', "redirect"=> $referrer], ['class' => 'btn btn-warning mb-10']) ?>
        <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
            'model' => $profile,
            'attributes' => $column
        ]) ?>
        </div>
    </div>
</div>