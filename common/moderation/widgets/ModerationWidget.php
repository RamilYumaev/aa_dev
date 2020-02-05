<?php

namespace common\moderation\widgets;

use yii\base\Widget;

class ModerationWidget extends Widget
{
    public $moderation;
    public function run()
    {
        return $this->render('moderation/index', [
            'moderation' => $this->moderation,
        ]);
    }
}
