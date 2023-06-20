<?php
namespace modules\entrant\models;

use common\auth\models\User;
use modules\entrant\behaviors\FileBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%psycho_test_spo}}".
 *
 * @property integer $id
 * @property integer $pass_exam_id
 **/

class PsychoTestSpo extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%psycho_test_spo}}';
    }

    public function behaviors()
    {
        return [FileBehavior::class];
    }

    public function getFiles()
    {
        return $this->hasMany(File::class, ['record_id' => 'id'])->where(['model' => self::class]);
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id'=> 'user_id']);
    }

    public function countFiles() {
        return $this->getFiles()->count();
    }
}