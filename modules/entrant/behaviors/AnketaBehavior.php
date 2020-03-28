<?php

namespace modules\entrant\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;
use yii\web\User;
use Yii;


class AnketaBehavior extends  Behavior
{

    /**
     * @return array
     */

    /**
     * @var BaseActiveRecord
     */
    public $owner;
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function beforeUpdate($event)
    {
        if($this->userCgExists() && !$this->checkUpdate())
        {
            UserCg::deleteAll(['user_id'=> Yii::$app->user->identity->getId()]);
        }
    }

    private function userCgExists()
    {
        return UserCg::find()->findUser()->exists();
    }

    private function checkUpdate()
    {
       return  $this->owner->oldAttributes == $this->owner->attributes;
    }

}