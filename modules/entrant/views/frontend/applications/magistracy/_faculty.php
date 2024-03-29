<?php
/**
 * @var $facultyArray
 * @var $currentFaculty
 * @var $department
 * @var $cg
 * @var $transformYear
 * @var $anketa modules\entrant\models\Anketa
 */

use dictionary\models\Faculty;
use \dictionary\helpers\DictCompetitiveGroupHelper;
use \dictionary\models\DictCompetitiveGroup;
use dictionary\helpers\DictDisciplineHelper;
use modules\dictionary\models\CathedraCg;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\CseSubjectHelper;
use yii\helpers\Html;
use modules\entrant\helpers\UserCgHelper;
use yii\widgets\Pjax;
use yii\web\View;
use \dictionary\models\DictDiscipline;
use \modules\entrant\helpers\Settings;
use \modules\entrant\helpers\AnketaHelper;

$this->title = "Магистратура. Институты/факультеты";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$result = "";
$anketa = \Yii::$app->user->identity->anketa();
$contractOnly = $anketa->onlyContract(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
?>
<?php
foreach ($currentFaculty as $faculty) {
    $cgFaculty = DictCompetitiveGroup::find()
        ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER)
        ->contractOnly()
        ->ForeignerCgSwitch()
        ->currentAutoYear()
        ->faculty($faculty)
        ->orderBy(['education_form_id' => SORT_ASC, 'speciality_id' => SORT_ASC])
        ->all();
    if ($cgFaculty) {
        $result .= "<h3>" .Html::a(\dictionary\helpers\DictFacultyHelper::facultyList()[$faculty],['get-magistracy', 'department'=> $department, 'faculty'=> $faculty]) . "</h3>";
    }
}
?>
<div class="row min-scr">
    <div class="button-left">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]) . " Уровни",
            ["anketa/step2"], ["class" => "btn btn-lg btn-warning position-fixed"]); ?>
    </div>
    <div class="button-right">
        <?= Html::a("Карточка " . Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-right"]), ["/abiturient"], ["class" => "btn btn-lg btn-success position-fixed"]); ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
    <h2 class="text-center"><?= $this->title ?></h2>
    <?php if($adminUserId = \Yii::$app->session->get('user.idbeforeswitch')) : ?>
        <?= \modules\entrant\widgets\anketa\AnketaCiWidget::widget(['userId' => Yii::$app->user->identity->getId(), 'view' => 'index-cg'])?>
    <?php endif;?>
    <div class="table-responsive" style="margin-top: 25px">
        <?= $result ?>
    </div>
    </div>
    </div>
</div>


