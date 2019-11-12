<?php
/* @var $this yii\web\View */
/* @var $model dod\models\DateDod */
/* @var $dod dod\models\DateDod */
?>
<?php if ($model) : ?>
    <?php foreach ($model as $dod) : ?>
        <div class="row">
            <div class="col-md-12 mt-10 dod_share">
                <div>
                    <h3 align="center"><?= $dod->dodOne->name ?></h3>
                    <p><i><?= $dod->dateStartString ?></i></p>
                    <p><i><?= $dod->timeStartString ?></i></p>
                    <p><?= $dod->dodOne->addressAndAudNumberString ?></p>
                    <?= $dod->dodOne->description ?>
                    <?= \frontend\widgets\dod\UserDodWidget::widget(['dod_id' => $dod->id]); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>