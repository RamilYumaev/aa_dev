<?php
/* @var $this yii\web\View */
/* @var $model \olympic\models\Olympic */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['registration-on-olimpiads', 'id' =>$model->id]);
?>

<div class="olimpic-item">
    <div class="h2"><a href="<?= Html::encode($url) ?>"><?= Html::encode($model->name) ?></a></div>
</div>