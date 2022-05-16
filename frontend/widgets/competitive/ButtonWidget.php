<?php
namespace frontend\widgets\competitive;

use dictionary\models\DictCompetitiveGroup;
use Yii;
use yii\base\Widget;

class ButtonWidget extends Widget
{
    /* @var $cgContract DictCompetitiveGroup */
    public $cgContract;
    public $eduLevel;

    public function run()
    {
        $cache = Yii::$app->cache;
        $key = 'button_list';
        $cgs = $cache->getOrSet($key, function ()  { return DictCompetitiveGroup::find()->currentAutoYear()->cgAllGroup($this->cgContract, $this->eduLevel); });
        return $this->render('button', [
            'cgs' => $cgs,
            'eduLevel' => $this->eduLevel,
            'cgContract' => $this->cgContract,
        ]);
    }
}