<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
?>
<div class="row">
    <div class="col-md-12">
        <h4>Профиль</h4>
        <?= Html::a('Редактировать', '@frontendInfo/profile/edit', ['class' => 'btn btn-primary']) ?>
        <?= DetailView::widget([
            'model' => $profile,
            'attributes' => [
                'last_name',
                'first_name',
                'patronymic',
                'phone',
                'country_id',
                'region_id'
            ],
        ]) ?>
    </div>
</div>