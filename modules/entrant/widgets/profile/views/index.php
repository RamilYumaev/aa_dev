<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
?>
<div class="row">
    <div class="col-md-12">
        <h4>Профиль</h4>
        <?= Html::a('Редактировать', '@frontendInfo/profile/edit', ['class' => 'btn btn-primary mb-10']) ?>
        <?= DetailView::widget([
            'model' => $profile,
            'attributes' => [
                'last_name',
                'first_name',
                'patronymic',
                'phone',
                ['label'=>$profile->getAttributeLabel('country_id'),
                    'value' =>$profile->countryName],
                ['label'=>$profile->getAttributeLabel('region_id'),
                    'value' =>$profile->regionName],
            ],
        ]) ?>
    </div>
</div>