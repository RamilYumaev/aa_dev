<?php

use testing\trail\assets\TrailAsset;
use yii\helpers\Html;
use common\widgets\Alert;
/* @var $this yii\web\View */
/* @var $content string */
TrailAsset::register($this);
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
        <title></title>
        <?php $this->head(); ?>
<?php if ($_SERVER['HTTP_HOST'] == 'sdo.mpgu.org') : ?>
        <script type="text/javascript" src="https://vk.com/js/api/openapi.js?165"></script>
<?php endif;?>
    </head>
    <body class="gray">
    <?php $this->beginBody(); ?>
    <div id="wrapper">
        <div class="container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
<?php if ($_SERVER['HTTP_HOST'] == 'sdo.mpgu.org') : ?>
    <div id="vk_community_messages"></div>
    <script type="text/javascript">
        VK.Widgets.CommunityMessages("vk_community_messages", 191157288, {disableExpandChatSound: "1",tooltipButtonText: "Есть вопрос?"});
    </script>
<?php endif;?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage();
