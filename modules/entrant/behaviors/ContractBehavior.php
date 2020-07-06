<?php

namespace modules\entrant\behaviors;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use libphonenumber\Leniency\ExactGrouping;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\readRepositories\ContractReadRepository;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use modules\entrant\models\UserCg;
use yii\db\BaseActiveRecord;
use Yii;

class ContractBehavior extends Behavior
{
    /**
     * @var StatementAgreementContractCg
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate'
        ];
    }

    public function beforeDelete($event)
    {
            if($this->owner->typePersonal() && $this->personal()) {
                PersonalEntity::findOne([ 'id'=> $this->owner->record_id, 'user_id' => $this->userId()])->delete();
            }
            if($this->owner->typeLegal() && $this->legal()) {
                LegalEntity::findOne([  'id'=> $this->owner->record_id, 'user_id' => $this->userId()])->delete();
        }
    }

    public function beforeUpdate($event)
    {   if ($this->owner->oldAttributes['type'] !== $this->owner->type) {
            if($this->owner->typePersonal() && $this->personal()) {
                PersonalEntity::findOne([  'id'=> $this->owner->record_id, 'user_id' => $this->userId()])->delete();
            }
            if($this->owner->typeLegal() &&$this->legal()) {
                LegalEntity::findOne([ 'id'=> $this->owner->record_id, 'user_id' => $this->userId()])->delete();
            }}
    }


    private function personal()
    {
        return PersonalEntity::find()->where([ 'id'=> $this->owner->record_id, 'user_id' => $this->userId()])->exists();
    }

    private function legal()
    {
        return LegalEntity::find()->where([ 'id'=> $this->owner->record_id,  'user_id' => $this->userId()])->exists();
    }

    private function userId()
    {
      return   $this->owner->statementCg->statement->user_id;
    }


}