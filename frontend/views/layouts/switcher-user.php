<?php
use yii\helpers\Html;
use common\auth\models\User;
?>


<?php if($adminUserId = \Yii::$app->session->get('user.idbeforeswitch')) : ?>
    <?php $user = User::findOne($adminUserId); ?>
    <div class="row min-scr">
        <div class="button-left">
            <?=Html::a("Обратно на $user->username", "/switch-user/come-back", ['class'=>'btn btn-info'])?>
        </div>
    </div>
<?php endif;?>