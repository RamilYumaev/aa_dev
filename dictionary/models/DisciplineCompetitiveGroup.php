<?php


namespace dictionary\models;


use dictionary\models\queries\DisciplineCompetitiveQuery;
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
        if ($competitiveGroup->isManyThree($competitive_group_id)) {
            throw new \DomainException('Не больше трех дисциплин.');
        }
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

    public function isManyThree($competitive_group_id): bool
    {
        $count = self::find()->where(['competitive_group_id' => $competitive_group_id])->count();
        return $count >= 3;
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

    public function getDiscipline()
    {
        return $this->hasOne(DictDiscipline::class, ['id' => 'discipline_id']);
    }

    public function getCompetitiveGroup()
    {
        return $this->hasOne(DictCompetitiveGroup::class, ['id' => 'competitive_group_id']);
    }

    public static function find(): DisciplineCompetitiveQuery
    {
        return new DisciplineCompetitiveQuery(static::class);
    }


}