<?php

namespace modules\entrant\behaviors;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;
use yii\web\User;
use Yii;


class AnketaBehavior extends Behavior
{

    /**
     * @return array
     */

    /**
     * @var BaseActiveRecord
     */
    public $owner;
    public $deleteType = "all";

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function beforeUpdate($event)
    {
        if ($this->userCgExists() && !$this->checkUpdate()) {
            if ($this->deleteType == "all") {
                UserCg::deleteAll(['user_id' => Yii::$app->user->identity->getId()]);
            } else {
                UserCg::deleteAll(['user_id' => Yii::$app->user->identity->getId(),
                    'cg_id' => $this->bachelorCg()]);

            }
        }

    }

    private function bachelorCg()
    {
        return DictCompetitiveGroup::find()
            ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)->column();
    }

    private function userCgExists()
    {
        return UserCg::find()->findUser()->exists();
    }

    private function checkUpdate()
    {
        return $this->owner->oldAttributes == $this->owner->attributes;
    }

}