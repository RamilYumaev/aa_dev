<?php

use yii\helpers\Html;
use dictionary\models\Faculty;
use yii\helpers\Json;

$this->title = 'Олимпиады и конкурсы МПГУ';
$this->params['breadcrumbs'][] = $this->title;
var_dump(Faculty::class);

$json =  Json::encode(Faculty::findOne(1));
$f = Json::decode($json);
var_dump($f);
?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>