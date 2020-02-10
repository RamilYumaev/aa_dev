<?php

namespace dictionary\models;
use dictionary\forms\DictSchoolsPreModerationForm;
use dictionary\helpers\DictCountryHelper;

class DictSchoolsReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    private $dict_school;

    public function __construct($config = [])
    {
        $this->dict_school = new DictSchools();
        parent::__construct($config);
    }

    public static function tableName()
    {
        return 'dict_schools_report';
    }

    public static function create($school_id)
    {
        $report = new static();
        $report->school_id = $school_id;

        return $report;
    }

    public function edit($school_id)
    {
        $this->school_id = $school_id;
    }



    /**
     * @return DictSchools
     */
    public function dictSchoolOne() {
        return $this->dict_school->schoolRelation($this->school_id)->one();
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'Название учебной организации',
        ];
    }

    public static function labels()
    {
        $report = new static();
        return $report->attributeLabels();
    }

}