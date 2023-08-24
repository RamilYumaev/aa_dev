<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $agreement modules\entrant\models\StatementAgreementContractCg */



if ($agreement->typeLegal()) : ?>
  <?=$this->render('_main_legal',['agreement'=> $agreement, 'anketa'=>$anketa]) ?>
<?php elseif ($agreement->typePersonal()) : ?>
   <?=$this->render('_main_personal',['agreement'=> $agreement, 'anketa'=>$anketa]) ?>
<?php else : ?>
    <?=$this->render('_main_entrant',['agreement'=> $agreement, 'anketa'=>$anketa]) ?>
<?php endif; ?>
<htmlpagefooter name="footer">
    <div>
Исполнитель: _________________ / Ж.И. Соболева<br />
тел.: 8(495) 438-18-57
    </div>
</htmlpagefooter>
<sethtmlpagefooter name="footer" />