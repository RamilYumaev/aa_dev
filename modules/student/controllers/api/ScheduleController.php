<?php
namespace modules\student\controllers\api;

use common\auth\services\PasswordResetService;
use modules\student\model\ScheduleLessons;
use yii\rest\Controller;
use yii\rest\Serializer;

class ScheduleController extends Controller
{
    private $service;

    public function __construct($id,  $module, PasswordResetService $userService,$config = [])
    {
        $this->service = $userService;
        parent::__construct($id, $module, $config);
    }

    public function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }

   public function actionIndex()
   {
       $dateToday = date("Y-m-d");
       $serializer = new Serializer();
       $begin = new \DateTime($dateToday);
       $data = [];
       $twoWeek = new \DateTime($dateToday);
       $twoWeek->modify('+5 week');
       $end = new \DateTime($twoWeek->format("Y-m-d"));
       for($i = $begin; $i <= $end; $i->modify('+1 day')) {
           $date = new \DateTime($i->format("Y-m-d"));
           $day = $date->format("N");
           $week = $date->format('W') % 2 == 0 ? 1 : 0;
           $scheduleLessons = ScheduleLessons::find()
               ->select(['number_pair','discipline_education_id', 'form','id'])
               ->andWhere(['day_week'=> $day])
               ->andWhere([ '<=', 'date_begin', $i->format("Y-m-d")])
               ->andWhere([ '>=', 'date_end', $i->format("Y-m-d")])
               ->with("disciplineEducation")
               ->with("scheduleLessonsTeachers.teacher")
               ->asArray()
               ->all();
           if($scheduleLessons) {
               $data[$i->format("Y-m-d")] = $scheduleLessons;
           }
       }
       return  $serializer->serialize($data);
   }
}
