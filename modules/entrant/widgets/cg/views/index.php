<?php
/* @var $this yii\web\View */
/* @var $userCg yii\db\BaseActiveRecord */
/* @var $userId integer */

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\UserCgHelper;
use yii\helpers\Html;

?>
    <div class="row">
        <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(UserCgHelper::findUser($userId)) ?>">
            <div class="p-30 green-border">
                <h4>Выбранные направления подготовки:</h4>
                <?= Html::a("Выбрать", '/abiturient/anketa/step2', ['class'=>'btn btn-info']);?>
                <?= Html::tag('button', 'Подробно',[ 'type'=>"button", 'id'=>"bool", 'class'=>"btn btn-warning",
                'data-toggle'=>"button",'aria-pressed'=>"false"])?>
                    <div id="compact">
                        <?= $this->render('_data/_compact',['userCg'=> $userCg]); ?>
                    </div>
                    <div id="full">
                        <?= $this->render('_data/_full',['userCg'=> $userCg, 'userId'=> $userId]); ?>
                    </div>
            </div>
        </div>
    </div>
<?php
$this->registerJs(<<<JS
"use strict";
var full = $('#full');
var compact = $('#compact');
full.hide();

$('#bool').click(function(e) {
    if($(this).attr("aria-pressed") == "false") {
        full.show();
        compact.hide();
        $(this).text("Кратко");
    }else {
        full.hide();
        compact.show();
        $(this).text("Подробно");
    }
});
JS
);