<?php

use yii\helpers\Html;
use dictionary\models\Faculty;
use yii\helpers\Json;

$this->title = 'Олимпиады и конкурсы МПГУ';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>