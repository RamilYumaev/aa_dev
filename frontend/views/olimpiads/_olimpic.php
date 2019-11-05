<?php
/* @var $this yii\web\View */
/* @var $model \olympic\models\Olympic */

use yii\helpers\Html;
use yii\helpers\Url;
use olympic\helpers\ClassAndOlympicHelper;

$url = Url::to(['registration-on-olimpiads', 'id' =>$model->id]);

?>
<div class="col-md-4">
    <div>
        <a href="<?= Html::encode($url) ?>">
            <h5 align="right"><?= $model->olympicOneLast->eduLevelString ?></h5>
            <div><h4><?= Html::encode($model->name) ?></h4></div>
            <p><?= Html::encode($model->olympicOneLast->promotion_text) ?></p>
            <span>Подробнее</span>
        </a>
    </div>
</div>