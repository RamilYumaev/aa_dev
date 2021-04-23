<?php
/* @var $this yii\web\View */
/* @var $rCls */
/* @var $type */
/* @var $rcl modules\dictionary\models\RegisterCompetitionList */
/* @var $cl modules\dictionary\models\CompetitionList */
use yii\helpers\Html;
?>
<?php foreach ($rCls as $index => $rcl) :?>
    <?php foreach ($rcl->getCompetitionList()->andWhere(['type'=> $type])->all() as $cl) :?>
        <?= Html::a(++$index,['list-one', 'id'=> $cl->id],['class'=>'btn btn-info']) ?>
    <?php endforeach;?>
<?php endforeach;?>