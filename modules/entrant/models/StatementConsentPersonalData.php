<?php

namespace modules\entrant\models;

use dictionary\models\DictCompetitiveGroup;
use modules\entrant\behaviors\FileBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%statement_consent_personal_data}}".
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
        return "{{%statement_consent_personal_data}}";
    }

    public function behaviors()
    {
        return [TimestampBehavior::class, FileBehavior::class];
    }


    public static function create($userId)
    {
        $statement = new static();
        $statement->user_id = $userId;
        return $statement;
    }

    public function setCountPages($countPages)
    {
        $this->count_pages = $countPages;
    }

    public function getFiles()
    {
        return $this->hasMany(File::class, ['record_id' => 'id'])->where(['model' => self::class]);
    }

    public function getAnketa()
    {
        return $this->hasOne(Anketa::class, ['user_id' => 'user_id']);
    }

    public function countFiles()
    {
        return $this->getFiles()->count();
    }

    public function countFilesINSend()
    {
        return $this->getFiles()->andWhere(['>', 'status', 0])->count();
    }

    public function countFilesAndCountPagesTrue()
    {
        return $this->count_pages && $this->countFiles() >= $this->count_pages;
    }

    public function attributeLabels()
    {
        return ["statement_id" => "Заявление", 'cg_id' => "Конкурсная группа", "status_id" => "Статус"];
    }

}