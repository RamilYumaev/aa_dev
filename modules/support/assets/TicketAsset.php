<?php

namespace modules\support\assets;

use yii\web\AssetBundle;

class TicketAsset extends AssetBundle {
    public $sourcePath = '@modules/support/assets/default';
    public $baseUrl = '@web';
    public $css = [
        'css/ticket-style.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}
