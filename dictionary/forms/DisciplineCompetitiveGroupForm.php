<?php


namespace dictionary\forms;


use dictionary\helpers\DictDisciplineHelper;
use dictionary\models\DisciplineCompetitiveGroup;
use yii\base\Model;

class DisciplineCompetitiveGroupForm extends Model
{
    public $discipline_id, $competitive_group_id, $priority, $spo_discipline_id;

    public function __construct($competitive_group_id, DisciplineCompetitiveGroup $disciplineCompetitiveGroup = null, $config = [])
    {
        if ($disciplineCompetitiveGroup) {
            $this->discipline_id = $disciplineCompetitiveGroup->discipline_id;
            $this->competitive_group_id = $disciplineCompetitiveGroup->competitive_group_id;
            $this->priority = $disciplineCompetitiveGroup->priority;
            $this->spo_discipline_id = $disciplineCompetitiveGroup->spo_discipline_id;
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
            [['discipline_id', 'competitive_group_id', 'priority', 'spo_discipline_id'], 'integer'],
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

    public function disciplineSpoList(): array
    {
        return DictDisciplineHelper::disciplineSpoList();
    }

    public function priorityList()
    {
        return ['1' => '1', '2' => '2', '3' => '3'];
    }
}
