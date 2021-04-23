<?php
namespace frontend\widgets\competitive;

use dictionary\models\DictCompetitiveGroup;
use yii\base\Widget;

class ButtonWidget extends Widget
{
    /* @var $cgContract DictCompetitiveGroup */
    public $cgContract;

    public function run()
    {
        $cgs = DictCompetitiveGroup::find()->cgAllGroup($this->cgContract);
        return $this->render('button', [
            'cgs' => $cgs,
        ]);
    }
}