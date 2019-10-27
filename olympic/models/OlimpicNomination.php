<?php


namespace olympic\models;


use yii\db\ActiveRecord;

class OlimpicNomination extends ActiveRecord
{

    public static function create($olimpic_id, $name)
    {
        $nomination = new static();
        $nomination->olimpic_id = $olimpic_id;
        $nomination->name = $name;
        return $nomination;
    }

    public function edit($olimpic_id, $name)
    {
        $this->olimpic_id = $olimpic_id;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'olimpic_nomination';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'olimpic_id' => 'Олимпиада',
            'name' => 'Название номинации',
        ];
    }

    public static function labels()
    {
        $nomination = new static();
        return $nomination->attributeLabels();
    }

}