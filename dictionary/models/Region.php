<?php

namespace dictionary\models;


class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_region';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название субъекта РФ',
            'ss_id' =>'Название субъекта РФ'
        ];
    }
}