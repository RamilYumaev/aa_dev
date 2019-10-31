<?php


namespace olympic\models;


use yii\db\ActiveRecord;

class ClassAndOlympic extends ActiveRecord
{
    public static function create($class_id, $olympic_id)
    {
        $classAndOlympic = new static();
        $classAndOlympic->class_id = $class_id;
        $classAndOlympic->olympic_id = $olympic_id;
        return $classAndOlympic;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'class_and_olympic';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'class_id' => 'Class ID',
            'olympic_id' => 'Olympic ID',
        ];
    }
}