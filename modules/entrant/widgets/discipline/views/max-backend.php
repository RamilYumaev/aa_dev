<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $maxSubjectResult array*/
use modules\dictionary\helpers\DictCseSubjectHelper;
?>
<?php if($maxSubjectResult):?>
    <?php Box::begin(
        ["header" => "Будут использованы следующие баллы ЕГЭ:", "type" => Box::TYPE_PRIMARY,
            "collapsable" => true,
        ]
    )
    ?>
        <?php foreach ($maxSubjectResult as $key => $value) :?>
            <?= DictCseSubjectHelper::name($key) .": ".$value; ?><br/>
        <?php endforeach;?>
        <?php  Box::end(); endif;?>