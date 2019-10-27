<?php


namespace olympic\models;


use yii\db\ActiveRecord;

class OlimpicCg extends ActiveRecord
{

    public static function create($olimpic_id, $competitive_group_id)
    {
        $olimpicCg = new static();
        $olimpicCg->olimpic_id = $olimpic_id;
        $olimpic_id->competitive_group_id = $competitive_group_id;

        return $olimpicCg;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olimpic_cg';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'olimpic_id' => 'Olimpic ID',
            'competitive_group_id' => 'Competitive Group ID',
        ];
    }

}