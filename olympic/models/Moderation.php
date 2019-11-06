<?php

namespace olympic\models;

use yii\db\ActiveRecord;

class Moderation extends ActiveRecord
{
    public static function create()
    {

    }

    public function edit()
    {

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

        ];
    }

    public static function labels()
    {
        $moderation = new static();
        return $moderation->attributeLabels();
    }


}