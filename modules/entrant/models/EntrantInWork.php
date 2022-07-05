<?php


namespace modules\entrant\models;


use modules\dictionary\models\JobEntrant;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * Class EntrantInWork
 * @package modules\entrant\models
 * @property  $user_id integer
 * @property $job_entrant_id integer
 * @property  $status integer
 */
class EntrantInWork extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%entrant_in_work}}';
    }

    public static function create($userId, $jobEntrantId)
    {
        $model = new static();
        $model->user_id = $userId;
        $model->job_entrant_id = $jobEntrantId;
        return $model;
    }

    public static function inWorkExists($userId)
    {
        return self::find()->andWhere(['user_id' => $userId])->exists();
    }

    public function getJobEntrant()
    {
        return $this->hasOne(JobEntrant::class, ['id' => 'job_entrant_id']);
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['user_id'=>'user_id']);
    }

    public function getAttributeLabels()
    {
        return [
            'user_id' => 'Абитуриент',
            'job_entrant_id'=> 'Сотрудник',
        ];
    }
}