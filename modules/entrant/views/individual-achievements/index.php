<?php
/**
 * @var $model modules\dictionary\models\DictIndividualAchievement
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use \modules\entrant\helpers\IndividualAchievementsHelper;
use yii\widgets\Pjax;


\frontend\assets\modal\ModalAsset::register($this);

$this->title = "Доступные индивидуальные достижения";
$this->params['breadcrumbs'][] = ["label" => "Добавление основных документов", "url" => "/abiturient/default"];
$this->params['breadcrumbs'][] = $this->title;

$result = "";

$result .= "<h1>" . $this->title . "</h1>";
$result .= "<p>Список индивидуальных достижений определяется на основе выбранных Вами образовательных программ</p>";


if ($model !== null) {
    $result .= "<table class=\"table table-bordered\">";
    $result .= "<tr><th>Описание индивидуального достижения</th><th>Действия</th></tr>";
    foreach ($model as $individualAchievement) {

        $result .= "<tr>";
        $result .= "<td>" . $individualAchievement->name . "</td>";
        $result .= "<td>" . IndividualAchievementsHelper::htmlButton($individualAchievement->id) . "</td>";
        $result .= "</tr>";
    }
    $result .= "</table>";
} else {
    $result .= "Ничего не найдено!";
}

?>

<div class="container">
    <div class="row">
        <?php Pjax::begin(['id' => 'get-individual', 'timeout' => false, 'enablePushState' => false]); ?>

        <?= Html::decode($result); ?>
        <?php Pjax::end(); ?>
    </div>

</div>
