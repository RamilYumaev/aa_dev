<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $document_education modules\entrant\models\DocumentEducation */
/* @var $isUserSchool bool */

?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($isData) ?>">
        <div class="p-30 green-border">
        <h4>Действующее образование</h4>
        <?php if ($isUserSchool) : ?>
        <?php else: ?>
            <p> Необходимо актуализировать
                раздел <?= Html::a('"Учебные организации"',
                    ['/schools/create', 'redirect' => 'transfer-registration'], ['class' => 'btn btn-warning']) ?></p>
        <?php endif; ?>
        </div>
    </div>
</div>