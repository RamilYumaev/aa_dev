<?php
/* @var $this yii\web\View */
/* @var $model dod\models\DateDod */
/* @var $dod dod\models\DateDod */

function color($b)
{
    if ($b % 6 == 0) {
        echo 'orange';
    } elseif ($b % 6 == 1) {
        echo 'red';
    } elseif ($b % 6 == 2) {
        echo 'green';
    } elseif ($b % 6 == 3) {
        echo 'purple';
    } elseif ($b % 6 == 4) {
        echo 'blue';
    } else {
        echo 'sky';
    }
}

$c = 0;
$b = 6;
?>
<?php if ($model): ?>
<div class="container">
    <div class="mt-60">
        <h2>Дни открытых дверей в институтах и факультетах МПГУ:</h2>
    </div>
    <?php foreach ($model as $dod) : ?>
        <?php if ($c % 3 == 0): ?>
            <div class="row">
        <?php endif; ?>
        <div class="col-md-4">
            <div class="dod-panel <?php color($b) ?>">
                <h3><?= $dod->dodOne->name ?></h3>
                <p><i><?= $dod->dateStartString ?></i></p>
                <p><i><?= $dod->timeStartString ?></i></p>
                <p><?= $dod->dodOne->addressString ?></p>
                <p><?= $dod->dodOne->audNumberString ?></p>
                <?= $dod->dodOne->description ?>
                <?= \frontend\widgets\dod\UserDodWidget::widget(['dod_id' => $dod->id]); ?>
            </div>
        </div>
        <?php if ($c % 3 == 2): ?>
            </div>
        <?php endif;
        $c++;
        $b++; ?>
    <?php endforeach; ?>
    <?php endif; ?>

</div>
