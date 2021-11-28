<?php
namespace modules\student\controllers\api;

use common\auth\models\User;
use common\auth\services\PasswordResetService;
use modules\student\model\ScheduleLessons;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
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
       $serialize = new Serializer();
       $dataProvider = ScheduleLessons::find()
           ->with("disciplineEducation")
           ->with("groupFaculty.dictFaculty")
           ->with("scheduleLessonsDates.teacher")
           ->with("scheduleLessonsTeachers.teacher")
           ->asArray()
           ->all();
       return  $serialize->serialize($dataProvider);
   }

}
