<?php
namespace modules\student\controllers\api;

use common\auth\forms\PasswordResetRequestForm;
use common\auth\services\PasswordResetService;
use modules\student\forms\MultiResetForm;
use yii\helpers\Json;
use yii\rest\Controller;

class ResetController extends Controller
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
            'index' => ['POST'],
        ];
    }

   public function actionIndex()
   {
       $json = $this->getJson();
       $data = Json::decode($json);
       $userForm = new MultiResetForm($data);
       if($userForm->type) {
           if(key_exists($userForm->type, $userForm->scenarios())) {
               $userForm->setScenario($userForm->type);
           }
       }
       if($userForm->validate()) {
           try{
               $this->service->requestApi($userForm);
               return ['success'=> 'Проверьте свою электронную почту и следуйте инструкциям, указанным в письме.'];
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
