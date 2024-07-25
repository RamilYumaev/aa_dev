<?php
/**
 * @var $this View
 * @var $faculty array
 */

use yii\helpers\Html;
use yii\web\View;
$this->title = "Конкурсные списки";
$this->params['breadcrumbs'][] = $this->title;

$vuz  = array_filter($faculty, function ($b) {
    return $b['filial'] == 0;
});

$filial  = array_filter($faculty, function ($b) {
    return $b['filial'] == 1;
})
?>

<div class="container">
    <div class="row">
        <div class=" col-xs-offset-1 col-xs-10 col-md-offset-3 col-md-6">
        <h1 style="margin-top: 54px; text-align: center"><?= $this->title ?></h1>
            <div style="margin: 0 auto; margin-top: 30px;">
                <?php foreach ($vuz as $value): ?>
                <h4 style="text-size: 25px; font-weight: 100" ><?= Html::a($value['full_name'], ['view', 'faculty_id' => $value['id']]) ?></h4>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class=" col-xs-offset-1 col-xs-10 col-md-offset-3 col-md-6">
            <h2 style="margin-top: 54px; text-align: center">Списки поступающих в филиалы МПГУ</h2>
            <div style="margin: 0 auto; margin-top: 30px;">
                <?php foreach ($filial as $value): ?>
                    <h4 style="text-size: 25px; font-weight: 100" ><?= Html::a($value['full_name'], ['view', 'faculty_id' => $value['id']]) ?></h4>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


