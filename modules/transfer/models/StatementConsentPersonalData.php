<?php

namespace modules\transfer\models;
use modules\transfer\behaviors\FileBehavior;
use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_consent_personal_data_transfer}}".
 *
 * @property integer $id
 * @property integer $user_id;
 * @property integer $created_at;
 * @property integer $updated_at;
 * @property integer $count_pages;
 **/

class  StatementConsentPersonalData extends ActiveRecord
{
    public static function tableName()
    {
        return  "{{%statement_consent_personal_data_transfer}}";
    }

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }

    public static function create($userId) {
        $statement = new static();
        $statement->user_id = $userId;
        return $statement;
    }

    public function setCountPages($countPages) {
        $this->count_pages = $countPages;
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['record_id'=> 'id'])->where(['model'=> self::class]);
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['user_id'=> 'user_id']);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }

    public function countFilesINSend() {
        return $this->getFiles()->andWhere(['>', 'status', 0])->count();
    }

    public function countFilesAndCountPagesTrue() {
        return $this->count_pages && $this->count_pages == $this->countFiles();
    }

    public function attributeLabels()
    {
        return ["statement_id" => "Заявление","status_id" => "Статус"];
    }
}