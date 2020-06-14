<?php

namespace modules\entrant\behaviors;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use libphonenumber\Leniency\ExactGrouping;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;
use Yii;

class ContractBehavior extends Behavior
{
    /**
     * @var BaseActiveRecord
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeDelete($event)
    {
        if($this->personal()) {
            PersonalEntity::deleteAll(['user_id' => $this->userId()]);
        }
        if($this->legal()) {
            LegalEntity::deleteAll(['user_id' => $this->userId()]);
        }
    }


    private function personal()
    {
        return PersonalEntity::find()->where(['user_id' => $this->userId()])->exists();
    }

    private function legal()
    {
        return LegalEntity::find()->where(['user_id' => $this->userId()])->exists();
    }

    private function userId()
    {
      return   $this->owner->statementCg->statement->user_id;
    }


}