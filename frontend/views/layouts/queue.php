<?php
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
) {
    header('X-UA-Compatible: IE=edge,chrome=1');
}
?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/img/favicon.png">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <?= $content ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage();
