<?php
/* @var $this yii\web\View */
/* @var $cgs */
/* @var $cg dictionary\models\DictCompetitiveGroup */
/* @var $cgContract dictionary\models\DictCompetitiveGroup */
/* @var $eduLevel*/

use yii\helpers\Html;
use dictionary\helpers\DictCompetitiveGroupHelper;

$array =
    [DictCompetitiveGroupHelper::USUAL => ['name'=>'<img src="/img/cabinet/b.png">',],
    DictCompetitiveGroupHelper::SPECIAL_RIGHT => ['name'=>'<img src="/img/cabinet/lg.png">',],
    DictCompetitiveGroupHelper::TARGET_PLACE => ['name'=>'<img src="/img/cabinet/c.png">',],
        'list_bvi' => ['name'=>'<img src="/img/cabinet/bvi.png">',]];

    $urlGraduate = ['entrant-graduate-list', 'faculty' => $cgContract->faculty_id, 'speciality' => $cgContract->speciality_id,
        'form' => $cgContract->education_form_id]
?>

<?php foreach ($cgs as $cg):
    $url = $eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL ?
        $urlGraduate + ['special' => $cg->special_right_id, 'finance' => $cg->financing_type_id, 'type'=> 'list'] :
        ['entrant-list', 'cg'=> $cg->ais_id, 'type'=> 'list'];
    ?>
    <?php if($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL): ?>
        <?php if($cg->getRegisterCompetitionListGraduate()): ?>
            <?php if($cg->isBudget()): ?>
                <?= Html::a($array[$cg->special_right_id]['name'],
                    $url ,['class'=>$array[$cg->special_right_id]['color']]) ?>
            <?php else: ?>
                <?= Html::a('<img src="/img/cabinet/dg.png">',$url,['class'=>'']) ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <?php if($cg->getRegisterCompetitionList('list')): ?>
            <?php if($cg->isBudget()): ?>
                <?= Html::a($array[$cg->special_right_id]['name'],
                    $url ,['class'=>$array[$cg->special_right_id]['color']]) ?>
            <?php else: ?>
                <?= Html::a('<img src="/img/cabinet/dg.png">',$url,['class'=>'']) ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($cg->isBudget() && $cg->getRegisterCompetitionList('list_bvi')): ?>
        <?= Html::a($array['list_bvi']['name'], ['entrant-list', 'cg' => $cg->ais_id, 'type' => 'list_bvi'],['class'=>$array['list_bvi']['color']]) ?>
    <?php endif; ?>

<?php endforeach;?>