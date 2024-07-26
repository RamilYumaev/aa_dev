<?php
/* @var $this yii\web\View */
/** @var $types */

use yii\helpers\Html;
$array =
    [
        'Основные места в рамках КЦП' => ['name'=>'<img src="/img/cabinet/b.png">', 'color' => '',],
        'Особая квота' => ['name'=>'<img src="/img/cabinet/lg.png">', 'color' => '',],
        'Целевая квота'=> ['name'=>'<img src="/img/cabinet/c.png">', 'color' => '',],
        'Отдельная квота' => ['name'=>'<img src="/img/cabinet/spec_quota.png">', 'color' => '',],
        'По договору об оказании платных образовательных услуг' => ['name'=>'<img src="/img/cabinet/dg.png">', 'color' => '',]];
?>

<?php foreach ($types as $type): ?>
    <?= Html::a($array[$type['type']]['name'], ['list', 'id' => $type['id']]) ?>
<?php endforeach;?>