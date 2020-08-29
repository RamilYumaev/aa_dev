<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\DictCompetitiveGroupHelper;

/* @var $this yii\web\View */
/* @var $infoda \modules\entrant\models\Infoda */

?>
<?php if ($infoda) : ?>
<div class="alert alert-warning" role="alert">
    <p>
        Логин: <?= $infoda->login ?> <br />
        Пароль: <?= $infoda->pass ?>
    </p>
    <p>
    Начните работу с электронными сервисами через свой Личный кабинет студента МПГУ <a href="https://lk.mpgu.su">https://lk.mpgu.su</a>!
    </p>
</div>
<p></p>
<?php endif; ?>
