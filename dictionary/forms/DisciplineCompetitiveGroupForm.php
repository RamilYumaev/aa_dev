<?php


namespace dictionary\forms;


use dictionary\helpers\DictDisciplineHelper;
use dictionary\models\DisciplineCompetitiveGroup;
use yii\base\Model;

class DisciplineCompetitiveGroupForm extends Model
{
    public $discipline_id, $competitive_group_id, $priority, $year;

    public function __construct($competitive_group_id, DisciplineCompetitiveGroup $competitiveGroup = null, $config = [])
    {
        if ($competitiveGroup) {
            $this->discipline_id = $competitiveGroup->discipline_id;
            $this->competitive_group_id = $competitiveGroup->competitive_group_id;
            $this->priority = $competitiveGroup->priority;
            $this->year = $competitiveGroup->year;
        } else {
            $this->competitive_group_id = $competitive_group_id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discipline_id', 'competitive_group_id', 'priority'], 'required'],
            [['discipline_id', 'competitive_group_id', 'priority', 'year'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return DisciplineCompetitiveGroup::labels();
    }

    public function disciplineList(): array
    {
        return DictDisciplineHelper::disciplineList();
    }

    public function priorityList()
    {
        return ['1' => '1', '2' => '2', '3' => '3'];
    }


}