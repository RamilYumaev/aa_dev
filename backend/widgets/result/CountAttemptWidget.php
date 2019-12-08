<?php
namespace backend\widgets\result;

use olympic\forms\search\OlimpicListSearch;
use olympic\models\PersonalPresenceAttempt;
use yii\base\Widget;
use Yii;

class CountAttemptWidget extends Widget
{
    public $olympic;

    /**
     * @var string
     */
    public $view = 'count-attempt/index';


    public function run()
    {
        return $this->render($this->view, [
            'countPresence' =>  $this->countPresence(),
            'countNoAppearance' => $this->countNoAppearance(),

        ]);
    }

    private function countPresence() {
       return PersonalPresenceAttempt::find()->olympic($this->olympic)->presence()->count();
    }

    private function countNoAppearance() {
        return PersonalPresenceAttempt::find()->olympic($this->olympic)->noAppearance()->count();
    }
}
