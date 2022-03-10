<?php
/* @var  $step int */
$titles = [
        1 => "Учетная запись",
        2 => "Личные данные",
        3 => "Образовательная организация участника",
        4 => "Прочие данныне участника",
        5 => "Сопровождающее лицо",
        6 => "Маршрут"
];
$url = [
    1 => ['register/index'],
    2 => ['register/step2'],
    3 => ['register/step3'],
    4 => ['register/step4'],
    5 => ['register/step5'],
    6 => ['register/step6'],
];
if(!$isRoute) {
    unset($titles[6]);
    unset($url[6]);
}
$this->params['breadcrumbs'][] = ['label' => 'Всероссийская олимпиада школьников по литературе', 'url' => ['default/index']];
$this->title= "Регистрация на участие. Шаг ".$step;
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .bs-wizard {margin-top: 40px;}

    /*Form Wizard*/
    .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
    .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
    .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
    .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
    .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
    .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
    .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
    .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
    .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
    .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
    .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
    .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
    .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
    .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
    /*END Form Wizard*/
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-20">
            <h1>Регистрация на участие в заключительном этапе Всероссийской олимпиады школьников по литературе в городе Москва в 2022 году.</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row bs-wizard" style="border-bottom:0;">
        <?php foreach ($titles as $key => $title):
            if ($step == $key) {$status = "active";}
            elseif ($step > $key) {$status = "complete";}
            else {$status = "disabled";} ?>
        <div class="col-xs-2 bs-wizard-step <?= $status ?>">
            <div class="text-center bs-wizard-stepnum">Шаг <?= $key ?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            <?= \yii\helpers\Html::a('', $url[$key], ['class'=>'bs-wizard-dot'])?>
            <div class="bs-wizard-info text-center"><?= $title ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>