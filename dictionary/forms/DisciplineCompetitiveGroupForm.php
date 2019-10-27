<?php


namespace dictionary\forms;


use dictionary\helpers\DictDisciplineHelper;
use dictionary\models\DisciplineCompetitiveGroup;
use yii\base\Model;

class DisciplineCompetitiveGroupForm extends Model
{
    public $discipline_id, $competitive_group_id, $priority;

    public function __construct(DisciplineCompetitiveGroup $competitiveGroup, $config = [])
    {
        if ($competitiveGroup) {
            $this->discipline_id = $competitiveGroup->discipline_id;
            $this->competitive_group_id = $competitiveGroup->competitive_group_id;
            $this->priority = $competitiveGroup->priority;
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
            [['discipline_id', 'competitive_group_id', 'priority'], 'integer'],
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


}