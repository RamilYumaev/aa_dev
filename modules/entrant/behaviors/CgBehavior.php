<?php

namespace modules\entrant\behaviors;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Statement;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;
use Yii;

class CgBehavior extends Behavior
{
    /**
     * @var BaseActiveRecord
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeUpdate($event)
    {
        if ($this->userCgExists() && !$this->checkUpdate()) {
            UserCg::deleteAll(['user_id' => Yii::$app->user->identity->getId(),
                    'cg_id' => $this->bachelorCg()]);
            Statement::deleteAll(['user_id' => Yii::$app->user->identity->getId(),
                'edu_level'=>DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR]);
        }

    }

    public function beforeDelete($event)
    {
        if ($this->userCgExists()) {
            UserCg::deleteAll(['user_id' => Yii::$app->user->identity->getId(),
                'cg_id' => $this->bachelorCg()]);
            Statement::deleteAll(['user_id' => Yii::$app->user->identity->getId(),
                'edu_level'=>DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR]);
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