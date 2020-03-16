<?php
/* @var $this yii\web\View */
/* @var $model dod\models\DateDod */
/* @var $dod dod\models\DateDod */
?>
<?php if ($model) : ?>
    <?php $modelCount = count($model);
    switch ($modelCount) {
        case 2:
            $md = 6;
            break;
        case 3;
            $md = 4;
            break;
        case 4;
            $md = 3;
            break;
        default:
            $md = 12;
    }
    ?>
    <div class="row">
        <?php foreach ($model as $dod) : ?>
             <?php  if(\dod\helpers\DateDodHelper::maxDate($dod->date_time, $dod->type, $dod->dod_id)):?>
                <div class="col-md-<?=$md?>">
                    <div class="dod_share">
                        <h3 align="center"><?= $dod->dodOne->name ?></h3>
                        <p><i> <?= $dod->dateStartString ?></i></p>
                        <p><i> <?= $dod->timeStartString ?></i></p>
                        <p> <?= $dod->dodOne->addressAndAudNumberString ?></p>
                        <?= $dod->dodOne->description ?>
                        <?= $dod->textString ?>
                        <?= \frontend\widgets\dod\UserDodWidget::widget(['dod_id' => $dod->id]); ?>
                    </div>
                </div>
         <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

