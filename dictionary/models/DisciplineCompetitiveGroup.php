<?php


namespace dictionary\models;


use yii\db\ActiveRecord;

class DisciplineCompetitiveGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discipline_competitive_group';
    }

    public static function create($discipline_id, $competitive_group_id, $priority)
    {
        $competitiveGroup = new static();
        $competitiveGroup->discipline_id = $discipline_id;
        $competitiveGroup->competitive_group_id = $competitive_group_id;
        $competitiveGroup->priority = $priority;

        return $competitiveGroup;
    }

    public function edit($discipline_id, $competitive_group_id, $priority)
    {
        $this->discipline_id = $discipline_id;
        $this->competitive_group_id = $competitive_group_id;
        $this->priority = $priority;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'discipline_id' => 'Дисциплина',
            'competitive_group_id' => 'Конкурсная группа',
            'priority' => 'Приоритет',
        ];
    }

    public static function labels()
    {
        $competitiveGroup = new static();
        return $competitiveGroup->attributeLabels();
    }

}