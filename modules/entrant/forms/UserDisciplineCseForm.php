<?php

namespace modules\entrant\forms;

use dictionary\models\DictDiscipline;
use modules\dictionary\helpers\DictCseSubjectHelper;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\DictCtSubject;
use modules\entrant\models\UserDiscipline;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserDisciplineCseForm extends Model
{
    public $mark, $discipline_id, $discipline_select_id, $year, $user_id, $type;
    public $key;
    public $composite = true;
    private $_userDiscipline;

    public function __construct(UserDiscipline $userDiscipline = null, $config = [])
    {
        if($userDiscipline) {
            $this->setAttributes($userDiscipline->getAttributes(), false);
            $this->_userDiscipline = $userDiscipline;
            $this->key = $userDiscipline->id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discipline_id', 'user_id', 'type'], 'required'],
            [['mark', 'year'], 'required', 'when'=> function($model) {
                return !in_array($model->type, [UserDiscipline::VI, UserDiscipline::NO]);
            }, 'enableClientValidation' => false],
            [['discipline_id', 'discipline_select_id', 'year'], 'integer'],
            [['mark', 'year'], 'trim'],
            [['mark'], 'integer', 'min' => 0, 'max' => 100],
            [['year'], 'validateYear'],
            [['composite'], 'boolean'],
            ['mark', 'validateMinSubject'],
            $this->uniqueRules()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['discipline_id'], 'unique', 'targetClass' => UserDiscipline::class,
            'targetAttribute' => ['user_id', 'discipline_id'], 'message'=>"Данный предмет Вы уже добавили"];
        if ($this->_userDiscipline) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_userDiscipline->id]]);
        }
        return $arrayUnique;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new UserDiscipline)->attributeLabels();
    }

    public function validateYear($attribute, $params)
    {
        if(!in_array($this->type, [UserDiscipline::VI, UserDiscipline::NO])) {
            $max = date("Y");
            $min = $this->minYear();
            if ($this->year < $min || $this->year > $max) {
                $this->addError('year', "Год сдачи от " . $min . " до " . $max);
                return false;
            }
            return true;
        }
        return true;
    }

    public function validateMinSubject($attribute, $params)
    {
        $discipline = DictDiscipline::findOne($this->discipline_id);
        if (!$discipline) {
            $this->addError('discipline_id', 'Такой предмет не существует');
            return false;
        } else {
            if($this->composite) {
                $attribute = !$discipline->composite_discipline ? 'discipline_id' : 'discipline_select_id';
                $discipline = !$discipline->composite_discipline ? $discipline : DictDiscipline::findOne($this->discipline_select_id);
            }else {
                $attribute = 'discipline_id';
            }
        if ($this->type == UserDiscipline::CSE || $this->type == UserDiscipline::CSE_VI) {
           return $this->validateMinCseSubject($discipline, $attribute);
        }elseif ($this->type == UserDiscipline::CT || $this->type == UserDiscipline::CT_VI) {
            return $this->validateMinCtSubject($discipline, $attribute);
        }
        return true;
        }
    }

    private function  validateMinCseSubject(DictDiscipline $discipline, $attribute) {
        if (!$discipline->cse_subject_id) {
            $this->addError($attribute, 'Такой предмет ЕГЭ не существует');
            return false;
        }
        $dictCseSubject = DictCseSubject::findOne($discipline->cse_subject_id);
        $min =  $dictCseSubject->min_mark;
        return $this->markCorrect($min, $dictCseSubject->name);
    }

    private function  validateMinCtSubject(DictDiscipline $discipline, $attribute) {
        if (!$discipline->ct_subject_id) {
            $this->addError($attribute, 'Такой предмет ЦТ не существует');
            return false;
        }
        $dictCtSubject = DictCtSubject::findOne($discipline->ct_subject_id);
        $min =  $dictCtSubject->min_mark;
        return $this->markCorrect($min, $dictCtSubject->name);
    }

    private function markCorrect($min, $name)
    {
        $max = DictCseSubjectHelper::MAX;
        if ($this->mark < $min || $this->mark > $max) {
            $this->addError('mark', $name. " от ".$min. " до ". $max);
            return false;
        }
        return true;
    }

    private function minYear() {
        return date("Y") - ($this->type == UserDiscipline::CSE || $this->type == UserDiscipline::CSE_VI ? 4 :  1);
    }
}