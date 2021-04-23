<?php
/* @var $this yii\web\View */
/* @var $cgs */
/* @var $cg dictionary\models\DictCompetitiveGroup */
use yii\helpers\Html;
use dictionary\helpers\DictCompetitiveGroupHelper;
$array =
    [DictCompetitiveGroupHelper::USUAL => ['name'=>'Бюджетные', 'color'=> 'btn btn-success', 'type' => 1],
    DictCompetitiveGroupHelper::SPECIAL_RIGHT => ['name'=>'Льготные', 'color'=> 'btn btn-info', 'type'=> 2],
    DictCompetitiveGroupHelper::TARGET_PLACE => ['name'=>'Целевые', 'color'=> 'btn btn-primary', 'type' => 3],
        3 => ['name'=>'Без Вст. Исп.', 'color'=> 'btn btn-warning', 'type' => 4]]
?>
<?php foreach ($cgs as $cg) :?>
    <?php if($cg->isBudget()): ?>
        <?= Html::a($array[$cg->special_right_id]['name'],['entrant-list', 'cg'=> $cg->ais_id, 'type'=> $array[$cg->special_right_id]['type']],['class'=>$array[$cg->special_right_id]['color']]) ?>
    <?php else: ?>
        <?= Html::a('Платные',['entrant-list', 'cg'=> $cg->ais_id, 'type'=> 1],['class'=>'btn btn-danger']) ?>
    <?php endif; ?>
    <?php if($cg->isBudget() && $cg->getCompetitiveList()->where(['type' => 4])->exists()): ?>
        <?= Html::a($array[3]['name'], ['entrant-list', 'cg' => $cg->ais_id, 'type' => $array[3]['type']],['class'=>$array[3]['color']]) ?>
    <?php endif; ?>
<?php endforeach;?>