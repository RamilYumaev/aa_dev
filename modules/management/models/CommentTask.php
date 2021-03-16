<?php

namespace modules\management\models;

use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use function GuzzleHttp\Psr7\normalize_header;

/**
 * This is the model class for table "{{%comment_task}}".
 *
 * @property string $text
 * @property integer $task_id
 * @property integer $created_by
 * @property integer $created_at
 **/

class CommentTask extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment_task}}';
    }


    public static function create($text, $task_id, $user_id)
    {
        $comment = new static();
        $comment->text = $text;
        $comment->task_id = $task_id;
        $comment->created_by = $user_id;
        $comment->created_at = date("Y-m-d H:i:s");
        return $comment;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['user_id' => 'created_by']);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Задача',
            'text' => 'Текст',
            'created_by' => "Кто создал?",
            'created_at' => "Дата создания",
        ];
    }

}