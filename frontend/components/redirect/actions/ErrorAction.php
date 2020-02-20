<?php
namespace frontend\components\redirect\actions;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;
use yii\base\Action;
use frontend\components\redirect\components\interfaces\IRedirectNewUrl;
use yii\web\Controller;


/**
 * Class ErrorAction
 *
 */
class ErrorAction extends Action
{   
   
    
    /**
     * @var  IRedirectNewUrl

     */
    private $_redirect;
   
      /**
     * ErrorAction constructor.
     *
     * @param string $id
     * @param Controller $controller
     * @param IRedirectNewUrl $redirect
     * @param array $config
     */
    public function __construct($id, Controller $controller, IRedirectNewUrl  $redirect,  array $config = [])
    {
      
        $this->_redirect = $redirect;  
        parent::__construct($id, $controller, $config);
    }
    
    /**
     * @return string
     */
    public function run() 
    {  
       $url =  $this->_redirect->newUrl(); 
       $exception = Yii::$app->errorHandler->exception;
       $name = $exception->getName();
       $message = $exception->getMessage(); 
       if ($exception !== null) {
           if ($url) {
             return $this->controller->redirect($url);
               }
        return $this->controller->render('@frontend/views/site/error',['name' => $name, 'message' => $message, 'exception' => $exception ]);
           }
    }
    
}