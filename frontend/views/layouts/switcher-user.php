<?php
use yii\helpers\Html;
use common\auth\models\User;
?>


<?php if($adminUserId = \Yii::$app->session->get('user.idbeforeswitch')) : ?>
    <?php $user = User::findOne($adminUserId); ?>
    <div class="row min-scr">
        <div class="button-right">
            <?=Html::a(HtmL::tag('span','',['class'=>'glyphicon glyphicon-eject']), "/switch-user/come-back", ['class'=>'btn btn-info'])?>
        </div>
    </div>
<?php endif;?>