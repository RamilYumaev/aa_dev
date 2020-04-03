<?php
/**
 * @var $model modules\dictionary\models\DictIndividualAchievement
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;


\frontend\assets\modal\ModalAsset::register($this);

$this->title = "Доступные индивидуальные достижения";
$result = "";

$result .= "<h1>Доступные индивидуальные достижения</h1>";
$result .= "<p>Список индивидуальных достижений определяется на основе выбранных Вами образовательных программ</p>";

if ($model !== null) {
    $result .= "<table class=\"table table-bordered\">";
    $result .= "<tr><th>Описание индивидуального достижения</th><th>Действия</th></tr>";
    foreach ($model as $individualAchievement) {
        $result .= "<tr>";
        $result .= "<td>" . $individualAchievement->name . "</td>";
        $result .= "<td>" . Html::a(Html::tag("span", "",
                ["class" => "glyphicon glyphicon-plus"]),
                ["add-individual-achievement", "individualId" => $individualAchievement->id],
                ["class" => "btn btn-success",
                    'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Добавить']) . "</td>";
        $result .= "</tr>";
    }
    $result .= "</table>";
} else {
    $result .= "Ничего не найдено!";
}

?>

<div class="container">
    <div class="row">
        <?= Html::decode($result); ?>
    </div>

</div>
