<?php

namespace common\tests\unit\dictionary\DictCompetitiveGroup;

use common\fixtures\dictionary\DictCompetitiveGroupFixture;
use dictionary\forms\DictCompetitiveGroupCreateForm;
use dictionary\models\DictCompetitiveGroup;

class DictCompetitiveGroupValidateCreateTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'cg' => [
                'class' => DictCompetitiveGroupFixture::class,
                'dataFile' => codecept_data_dir() . 'dictionary/dict-competitive-group.php',
            ],
        ]);
    }

    public function testValidateEmpty()
    {
        $model = new DictCompetitiveGroupCreateForm();
        $model->speciality_id = "";
        $model->specialization_id = "";
        $model->edu_level = "";
        $model->education_form_id = "";
        $model->education_duration = "";
        $model->financing_type_id = "";
        $model->faculty_id = "";
        $model->kcp = "";
        $model->special_right_id = "";
        $model->competition_count = "";
        $model->passing_score = "";
        $model->link = "";
        $model->is_new_program = "";
        $model->only_pay_status = "";

        $this->assertFalse($model->validate());

    }

    public function testValidateSuccess()
    {
        $model = new DictCompetitiveGroupCreateForm();
        $model->speciality_id = "22";
        $model->specialization_id = "3";
        $model->edu_level = "1";
        $model->education_form_id = "1";
        $model->education_duration = "4";
        $model->financing_type_id = "1";
        $model->faculty_id = "8";
        $model->kcp = "19";
        $model->special_right_id = "0";
        $model->competition_count = "19.1";
        $model->passing_score = "234";
        $model->link = "234";
        $model->is_new_program = "0";
        $model->only_pay_status = "0";
        $this->assertTrue($model->validate());
    }

    public function testValidateErrorWithoutKcp()
    {
        $model = new DictCompetitiveGroupCreateForm();
        $model->speciality_id = "22";
        $model->specialization_id = "3";
        $model->edu_level = "1";
        $model->education_form_id = "1";
        $model->education_duration = "4";
        $model->financing_type_id = "1";
        $model->faculty_id = "8";
        $model->kcp = "";
        $model->special_right_id = "0";
        $model->competition_count = "19.1";
        $model->passing_score = "234";
        $model->link = "http://mpgu.su/ob-mpgu/struktura/faculties/geograficheskiy-fakultet/bakalavriat/turizm-43-03-02/";
        $model->is_new_program = "0";
        $model->only_pay_status = "0";
        $this->assertFalse($model->validate());
    }

    public function testValidateUnique()
    {
        $model = new DictCompetitiveGroupCreateForm();
        $model->speciality_id = "12";
        $model->specialization_id = "2";
        $model->edu_level = "1";
        $model->education_form_id = "1";
        $model->education_duration = "4";
        $model->financing_type_id = "1";
        $model->faculty_id = "8";
        $model->kcp = "15";
        $model->special_right_id = "0";
        $model->competition_count = "16.2";
        $model->passing_score = "180";
        $model->link = "http://mpgu.su/ob-mpgu/struktura/faculties/geograficheskiy-fakultet/bakalavriat/05-03-06-ekologiya-i-
        prirodopolzovanie-profil-geoekologiya-ochnaya-forma-4-goda/";
        $model->is_new_program = "0";
        $model->only_pay_status = "0";
        $this->assertFalse($model->validate());
        $this->assertEquals("Такое сочетание уже есть", $model->getFirstError('speciality_id'));

    }
}