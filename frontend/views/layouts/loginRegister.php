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
<?php if ($_SERVER['HTTP_HOST'] == 'sdo.mpgu.org') : ?>

    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?165"></script>
<?php endif;?>
    </head>
    <body class="mpgu-bg">
    <?php $this->beginBody(); ?>
    <div id="vk_community_messages"></div>
<?php if ($_SERVER['HTTP_HOST'] == 'sdo.mpgu.org') : ?>
    <script type="text/javascript">
        VK.Widgets.CommunityMessages("vk_community_messages", 191157288, {disableExpandChatSound: "1",tooltipButtonText: "Есть вопрос?"});
    </script>
<?php endif;?>
    <div id="wrapper">
        <div class="container-fluid">
            <?= $content ?>
        </div>
    </div>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage();
