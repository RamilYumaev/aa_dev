<?php
namespace olympic\forms\traits;

use common\helpers\EduYearHelper;
use dictionary\helpers\DictFacultyHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;

trait OlympicTrait
{
    public $name,
        $chairman_id,
        $number_of_tours,
        $edu_level_olymp,
        $genitive_name,
        $faculty_id,
        $competitiveGroupsList,
        $classesList,
        $time_of_distants_tour_type,
        $form_of_passage,
        $time_of_tour,
        $content,
        $required_documents,
        $showing_works_and_appeal,
        $time_of_distants_tour,
        $prefilling,
        $only_mpgu_students,
        $list_position,
        $auto_sum,
        $date_time_start_tour,
        $address,
        $requiment_to_work_of_distance_tour,
        $requiment_to_work,
        $criteria_for_evaluating_dt,
        $criteria_for_evaluating,
        $promotion_text,
        $link,
        $certificate_id,
        $event_type,
        $olimpic_id,
        $year,
        $date_range,
        $percent_to_calculate,
        $cg_no_visible,
        $is_volunteering,
        $is_remote,
        $_olympic;


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return OlimpicList::labels();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

    public function numberOfTours()
    {
        return OlympicHelper::numberOfTours();
    }

    public function listPosition()
    {
        return OlympicHelper::listPosition();
    }

    public function formOfPassage()
    {
        return OlympicHelper::formOfPassage();
    }

    public function levelOlimp()
    {
        return OlympicHelper::levelOlimp();
    }

    public function showingWork()
    {
        return OlympicHelper::showingWork();
    }

    public function prefilling()
    {
        return OlympicHelper::prefilling();
    }

    public function chairmansFullNameList()
    {
        return \dictionary\helpers\DictChairmansHelper::chairmansFullNameList();
    }

    public  function typeOfTimeDistanceTour() {

        return OlympicHelper::typeOfTimeDistanceTour();
    }

    public function years(): array
    {
        return EduYearHelper::eduYearList();
    }

}