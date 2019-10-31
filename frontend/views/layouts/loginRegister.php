<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
) {
    header('X-UA-Compatible: IE=edge,chrome=1');
}

AppAsset::register($this);
?>

    <title><?= Html::encode($this->title) ?></title>

<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/img/favicon.png">
        <?= Html::csrfMetaTags() ?>
        <?php $this->head(); ?>
    </head>
    <body class="mpgu-bg">
    <?php $this->beginBody(); ?>
    <div id="wrapper">
        <div class="container-fluid">
            <?= $content ?>
        </div>
    </div>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage();
