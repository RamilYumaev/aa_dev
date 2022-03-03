<?php
namespace modules\literature\controllers\api;

use yii\rest\Controller;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
    }

    public function verbs()
    {
        return [
            'index' => ["GET"],
      ];
   }
}
