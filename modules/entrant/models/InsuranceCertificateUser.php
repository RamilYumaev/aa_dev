<?php


namespace modules\entrant\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\helpers\AddressHelper;

/**
 * This is the model class for table "{{%insurance_certificate_user}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
**/
class InsuranceCertificateUser extends YiiActiveRecordAndModeration
{
    public function behaviors()
    {
        return ['moderation' => [
            'class'=> ModerationBehavior::class,
            'attributes'=>['number'],
        ], FileBehavior::class];
    }


    public function data($number, $userId) {
        $this->number = $number;
        $this->user_id = $userId;
    }

    public static function tableName()
    {
        return "{{%insurance_certificate_user}}";
    }

    public function titleModeration(): string
    {
        return "СНИЛС";
    }

    public function moderationAttributes($value): array
    {
        return [
            'number' => $value,
        ];
    }

    public function attributeLabels()
    {
        return [
            'number'=> 'СНИЛС'
        ];
    }
    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

}