<?php
/* @var $this yii\web\View */
/* @var $colorBox  string */
/* @var $icon  string */
/* @var $str  string */
/* @var $link string */
/* @var $count integer */

use backend\widgets\adminlte\InfoBox;
?>
<?= InfoBox::widget([
        "color" => $colorBox,
        "icon" =>  $icon,
        "text" =>  $str,
        "number" => $count])?>
