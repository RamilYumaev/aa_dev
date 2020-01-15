<?php
/* @var $this yii\web\View */
/* @var $menu */
/* @var $url */
use dictionary\helpers\DictFacultyHelper;
use yii\widgets\Menu;

$items= [];
foreach ($menu as $faculty) {
    $items[] = ['label' => DictFacultyHelper::facultyName($faculty->id),
        'url' => [$url, 'faculty' => $faculty->id]];
}
?>
<?= Menu::widget([
'items' => $items
]); ?>