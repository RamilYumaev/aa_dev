<?php
namespace frontend\widgets\competitive;

use dictionary\helpers\DictCompetitiveGroupHelper;
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
        $cgs = $cache->getOrSet($key, function ()  {
            return $this->cgContract->faculty_id == 6 ?  DictCompetitiveGroup::find()
                ->currentAutoYear()->cgAllGroup($this->cgContract, $this->eduLevel) :
                DictCompetitiveGroup::find()->currentAutoYear()
                ->with( $this->eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR ?
                    ['registerCompetition.competitionListNo', 'registerCompetition.competitionListBvi'] :
                    ['registerCompetition.competitionListNo',])
                ->cgAllGroup($this->cgContract, $this->eduLevel); });
        return $this->render('button', [
            'cgs' => $cgs,
            'eduLevel' => $this->eduLevel,
            'cgContract' => $this->cgContract,
        ]);
    }
}