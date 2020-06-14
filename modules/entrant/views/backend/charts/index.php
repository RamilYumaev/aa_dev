<?php
/* @var $cgs \yii\db\BaseActiveRecord */
/* @var $cg \dictionary\models\DictCompetitiveGroup */

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\helpers\DictSpecializationHelper;

\entrant\assets\ChartAsset::register($this);
$this->title = "Ход подачи документов";
?>

<div class="row">
<?php foreach ($cgs as $key => $cg) :?>
   <div class="col-md-4">
  <?= \modules\entrant\widgets\cpk\charts\ChartBarWidget::widget(['key' => $key, 'cg'=> $cg])?>
   </div>
<?php endforeach;?>
</div>

