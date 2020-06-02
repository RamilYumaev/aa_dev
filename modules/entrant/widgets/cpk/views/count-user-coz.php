<?php
/* @var $this yii\web\View */
/* @var $colorBox  string */
/* @var $icon  string */
/* @var $str  string */
/* @var $link string */
/* @var $count integer */
use backend\widgets\adminlte\SmallBox;
?>
<?= SmallBox::widget(
    [
        "color" => $colorBox,
        "header" => $count,
        "icon" => $icon,
        "text" => $str,
        'linkRoute'=> $link,
        'linkLabel' => 'Подробно <i class="fa fa-arrow-circle-right"></i>'
    ]
)
?>
