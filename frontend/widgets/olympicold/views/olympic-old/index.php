<?php
/* @var $this yii\web\View */
/* @var $model \olympic\models\OlimpicList */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php if ($model) : ?>
<div>
    <p>Олимпиады прошлых лет</p>
    <?php foreach ($model as $oldOlymic) : ?>
    <?php $url = Url::to(['olympic-old', 'id' => $oldOlymic->id]); ?>
        <div>
            <a href="<?= Html::encode($url) ?>">
                <h5><?= $oldOlymic->year ?></h5>
            </a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>