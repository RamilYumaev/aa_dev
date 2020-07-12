<?php


namespace modules\dictionary\forms;
use modules\dictionary\helpers\DisciplineExaminerHelper;
use modules\dictionary\models\DictExaminer;
use yii\base\Model;

class DictExaminerForm extends Model
{
    public $fio, $disciplineList;
    private $_examiner;

    public function __construct(DictExaminer $examiner = null, $config = [])
    {
        if ($examiner) {
            $this->setAttributes($examiner->getAttributes(), false);
            $this->_examiner = $examiner;
            $this->disciplineList = DisciplineExaminerHelper::listDisciplineExaminer($this->_examiner->id);
        } else {
            $this->disciplineList = [];

        }
        parent::__construct($config);
    }

    public function defaultRules()
    {
        return [
            [['fio', 'disciplineList'], 'required'],
             ['fio', 'trim'],
            [['disciplineList'], 'safe'],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['fio'], 'unique', 'targetClass' => DictExaminer::class];
        if ($this->_examiner) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_examiner->id]]);
        } else {
            return $arrayUnique;
        }
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictExaminer())->attributeLabels();
    }

}