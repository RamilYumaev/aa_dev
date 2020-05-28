<?php
/* @var $this yii\web\View */
/* @var $userCg yii\db\BaseActiveRecord */
/* @var $userId integer */

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\UserCgHelper;
use yii\helpers\Html;

?>
<?php Box::begin(
    ["header" => "Образовательные программы:", "type" => Box::TYPE_SUCCESS,
        "collapsable" => true,
    ]
)
?>
<?= Html::tag('button', 'Подробно',[ 'type'=>"button", 'id'=>"bool", 'class'=>"btn btn-warning",
    'data-toggle'=>"button",'aria-pressed'=>"false"])?>
    <div id="compact">
        <?= $this->render('_data/_compact',['userCg'=> $userCg]); ?>
    </div>
    <div id="full">
        <?= $this->render('_data/_full',['userCg'=> $userCg, 'userId'=> $userId]); ?>
    </div>
<?php Box::end();

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