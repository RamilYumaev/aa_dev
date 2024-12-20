<?php

namespace modules\entrant\forms;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\DictCseSubjectHelper;
use modules\entrant\models\CseViSelect;
use yii\base\Model;

class TypeExaminationsForm extends Model
{
    public $type;
    public $str;
    public $mark;
    public $year;
    public $language;
    private $key;

    public $isData;

    public function __construct($exam = null, $key = null, CseViSelect $cseViSelect = null, $config = [])
    {
        $this->key = $key;
        $this->str = $exam;
        if($cseViSelect) {
            if($cseViSelect->dataVi() && key_exists($key, $cseViSelect->dataVi())) {
                    $this->type = 0;
                    $this->isData = true;
                    if ($this->key == DictCseSubjectHelper::LANGUAGE) {
                        $this->language = $cseViSelect->dataVi()[$this->key];
                    }
                }
            elseif($cseViSelect->dataCse() && key_exists($key, $cseViSelect->dataCse())) {
                $this->type = 1;
                $this->isData = true;
                if ($this->key == DictCseSubjectHelper::LANGUAGE) {
                    $this->language = $cseViSelect->dataCse()[$this->key][1];
                }
                $this->mark = $cseViSelect->dataCse()[$this->key][2] ?? null;
                $this->year = $cseViSelect->dataCse()[$this->key][0] ?? null;
                }
        } else {
            $this->isData = false;
            $this->type = null;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type','language'], 'integer'],
            ['mark', 'integer', 'min' => 0, 'max' => 100],
            [['year'], 'integer', 'min' => date("Y") - 4, 'max' => date("Y")],
            [['mark','type'], 'validateTypeMark'],
            [['year','type'], 'validateYearMark'],
            [['mark'], 'validateMark']
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'ВИ или ЕГЭ',
            'year' => 'Год',
            'mark' => 'Балл',
        ];
    }

    private function intDate() {
        return (int) date("Y");
    }

    public function validateTypeMark()
    {
        if ($this->type && !$this->mark) {
            $this->addError('mark', 'Заполните балл EГЭ');
            return false;
        }
        return true;
    }

    public function validateYearMark()
    {
        if ($this->type && !$this->year) {
            $this->addError('year', 'Заполните год сдачи EГЭ');
            return false;
        }
        return true;
    }


    public function validateMark()
    {
        if($this->key) {
            $cse = DictCompetitiveGroupHelper::cseSubjectId($this->key);
            $min = DictCseSubjectHelper::valueMark($this->language ?? $cse);
            if ($min) {
                $max = DictCseSubjectHelper::MAX;
                if (($this->mark < $min || $this->mark > $max)) {
                    $this->addError('mark', DictCseSubjectHelper::name($this->language ?? $cse) . " от " . $min . " до " . $max);
                    return false;
                }
            }

            return true;
        }
    }

}