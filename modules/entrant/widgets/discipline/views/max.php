<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $maxSubjectResult array*/
use modules\dictionary\helpers\DictCseSubjectHelper;
?>
<div class="row">
    <div class="col-md-12">
        <?php if($maxSubjectResult):?>
            <h4>Будут использованы следующие баллы ЕГЭ:</h4>
        <?php foreach ($maxSubjectResult as $key => $value) :?>
            <?= DictCseSubjectHelper::name($key) .": ".$value; ?><br/>
        <?php endforeach;?>
        <?php endif;?>
    </div>
</div>
