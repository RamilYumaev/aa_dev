<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
$color = $profile->dataNoEmpty() ? 'bg-success' : 'bg-danger';
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
    <div class="col-md-12 <?= $color ?>">
        <h4>Профиль</h4>
        <?= Html::a('Редактировать', '@frontendInfo/profile/edit', ['class' => 'btn btn-primary mb-10']) ?>
        <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
            'model' => $profile,
            'attributes' => $column
        ]) ?>
    </div>
</div>