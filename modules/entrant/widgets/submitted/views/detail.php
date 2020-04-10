<?php
/* @var $this yii\web\View */
/* @var $submitted modules\entrant\models\SubmittedDocuments */
/* @var $userCg yii\db\BaseActiveRecord */
/* @var $userId integer */

use dictionary\helpers\DictCompetitiveGroupHelper;

?>
<div class="row">
    <div class="col-md-12">
        <div class="mt-20">
            <?php if($submitted): ?>
                <h4>Ваш способ подачи документов - <?= $submitted->typeName?> </h4>
                <button type="button" id="bool" class="btn btn-info" data-toggle="button" aria-pressed="false">
                   Подробно
                </button>
                <div id="compact">
                    <?= $this->render('_data/_compact',['userCg'=> $userCg]); ?>
                </div>
                <div id="full">
                    <?= $this->render('_data/_full',['userCg'=> $userCg, 'userId'=> $userId]); ?>
                </div>
            <?php endif; ?>
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


