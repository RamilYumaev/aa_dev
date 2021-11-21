<?php
namespace modules\student\controllers\api;

use olympic\forms\auth\UserCreateForm;
use olympic\services\auth\UserService;
use yii\helpers\Json;
use yii\rest\Controller;

class RegisterController extends Controller
{
    private $service;

    public function __construct($id,  $module, UserService $userService,$config = [])
    {
        $this->service = $userService;
        parent::__construct($id, $module, $config);
    }

    public function verbs()
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
        ];
    }

    public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
   }

   public function actionCreate()
   {
       $json = $this->getJson();
       $data = Json::decode($json);
       $userForm = new UserCreateForm($data);
       if($userForm->validate()) {
           try{
               $model = $this->service->createUserForApi($userForm);
               return ['email'=>$model->user->email, 'token' => $model->token ];
           }catch (\DomainException $e) {
               return ['errorMessage' => $e->getMessage()];
           }
       } else {
           return ['errorMessage' => $userForm->errors];
       }
   }

    private function getJson()
    {
        try {
            $json = file_get_contents('php://input');
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            return ['message' => $e->getMessage()];
        }
        return $json;
    }
}
