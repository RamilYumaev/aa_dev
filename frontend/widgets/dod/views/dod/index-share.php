<?php
/* @var $this yii\web\View */
/* @var $model dod\models\DateDod */
/* @var $dod dod\models\DateDod */
?>
<?php if ($model) : ?>
    <?php foreach ($model as $dod) : ?>
        <div class="col-md-12 mt-10 dod_share">
            <div>
                <h1 align="center"><?= $dod->dodOne->name ?></h1>
                <p><i><?= $dod->dateStartString ?></i></p>
                <p><i><?= $dod->timeStartString ?></i></p>
                <p><?= $dod->dodOne->addressAndAudNumberString ?></p>
                <?= $dod->dodOne->description ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>