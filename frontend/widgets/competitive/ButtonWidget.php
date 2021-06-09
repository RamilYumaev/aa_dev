<?php
namespace frontend\widgets\competitive;

use dictionary\models\DictCompetitiveGroup;
use yii\base\Widget;

class ButtonWidget extends Widget
{
    /* @var $cgContract DictCompetitiveGroup */
    public $cgContract;
    public $eduLevel;

    public function run()
    {
        $cgs = DictCompetitiveGroup::find()->currentAutoYear()->cgAllGroup($this->cgContract, $this->eduLevel);
        return $this->render('button', [
            'cgs' => $cgs,
            'eduLevel' => $this->eduLevel,
            'cgContract' => $this->cgContract,
        ]);
    }
}