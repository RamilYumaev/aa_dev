<?php
namespace common\moderation\models;

use common\moderation\helpers\ModerationHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Moderation extends ActiveRecord
{



    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
           TimestampBehavior::class,
        ];
    }


    public static function create($model, $id, $before, $after)
    {
        $moderation = new static();
        $moderation->model = $model;
        $moderation->record_id = $id;
        $moderation->before = $before;
        $moderation->after = $after;
        $moderation->created_by = self::getUser();
        return $moderation;
    }

    public static function getUser () {
        return \Yii::$app->user->identity->getId()
                && !\Yii::$app->user->isGuest ?
            \Yii::$app->user->identity->getId()  : null;
    }

    public function getBeforeData() {
        return $this->before ? Json::decode($this->before): null;
    }

    public function getAfterData() {
       return Json::decode($this->after);
    }

    public function getModel()
    {
        return new $this->model;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->moderated_by = \Yii::$app->user->identity->getId();
    }

    public function  setMessage($message)
    {
        $this->message = $message;
    }

    public function  isStatusNew()
    {
        return $this->status == ModerationHelper::STATUS_NEW;
    }

    public function  isStatusReject()
    {
        return $this->status == ModerationHelper::STATUS_REJECT;
    }

    public function  isStatusTake()
    {
        return $this->status == ModerationHelper::STATUS_TAKE;
    }


    public function getBefore($key) {
       return ArrayHelper::getValue($this->getBeforeData(), $key);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moderation';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'model' => "Модель",
            'record_id' => "Ид модели",
            'created_by' => "Кто создал?",
            'moderated_by' => "Кто проверял?",
            'created_at' => "Дата создания",
            'updated_at' => "Дата обновления",
            'status' => "Статус",
            'message' => "Причина отклонения"
        ];
    }

    public static function labels()
    {
        $moderation = new static();
        return $moderation->attributeLabels();
    }


}