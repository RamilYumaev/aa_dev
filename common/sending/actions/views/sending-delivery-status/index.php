<?php

use common\auth\helpers\UserSchoolHelper;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\helpers\DictClassHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type int */
/* @var $typeModel int */
/* @var $model \yii\db\ActiveRecord/ */

?>
<?php if ($typeModel == SendingDeliveryStatusHelper::TYPE_OLYMPIC) :?>
    <?= $this->render('_olympic', ['type' =>$type, 'olympic'=>$model, 'dataProvider'=> $dataProvider ])?>
<?php else: ?>
    <?= $this->render('_dod', ['type' =>$type, 'dateDod'=>$model, 'dataProvider'=> $dataProvider ])?>
<?php endif; ?>
