<?php


namespace modules\entrant\behaviors;


use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\CseSubjectResult;
use modules\entrant\models\PassportData;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class CseDeleteBehavior extends Behavior
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
    public function beforeUpdate()
    {
        if ($this->userCseResultExist() && !$this->checkUpdate()) {
            CseSubjectResult::deleteAll($this->userWhere());
        }
        if ($this->userBirthDocument() && !$this->checkUpdate()) {
            PassportData::deleteAll(['user_id' => Yii::$app->user->identity->getId(),
                'type'=> [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT,
                DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT]]);
        }
    }

    private function userCseResultExist()
    {
        return CseSubjectResult::find()->where($this->userWhere())->exists();
    }

    private function userBirthDocument()
    {
        return PassportData::find()->where($this->userWhere())
            ->andWhere(['type'=> [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT,
                DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT]])
            ->exists();
    }

    private function userWhere() {
        return ['user_id' => Yii::$app->user->identity->getId()];
    }

    private function checkUpdate()
    {
        return $this->owner->oldAttributes['exemption_id'] == $this->owner->attributes['exemption_id'];
    }
}