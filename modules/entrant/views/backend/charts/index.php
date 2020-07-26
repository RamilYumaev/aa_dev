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


<?php foreach ($cgs as $key => $cg) : ?>
    <?php if ($key % 3 == 0): ?>
        <div class="row">
    <?php endif; ?>
            <div class="col-md-4">
                <?= \modules\entrant\widgets\cpk\charts\ChartBarWidget::widget(['key' => $key, 'cg' => $cg]) ?>
            </div>
    <?php if ($key % 3 == 2): ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

