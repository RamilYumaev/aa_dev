<?php


namespace modules\dictionary\forms;


use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictSchedule;
use yii\base\Model;

class  DictScheduleForm extends Model
{
    public $date, $category, $count;
    private $_dictSchedule;


    public function __construct(DictSchedule $dictSchedule = null, $config = [])
    {
        if($dictSchedule){
            $this->setAttributes($dictSchedule->getAttributes(), false);
            $this->_dictSchedule = $dictSchedule;
        }

        parent::__construct($config);
    }

    public function uniqueRules()
    {
        $arrayUnique = [['date'], 'unique', 'targetClass' => DictSchedule::class, 'targetAttribute'=>['date','category', ]];
        if ($this->_dictSchedule) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_dictSchedule->id]]);
        }
        return $arrayUnique;
    }

    public function defaultRules()
    {
        return [
            [['date','category','count'], 'required'],
            [['date'], 'date', 'format' => 'Y-m-d'],
            [['category','count'], 'integer'],
            [['count'], 'integer', 'min'=> 1, 'max' => 100],
        ];
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictSchedule())->attributeLabels();
    }
}