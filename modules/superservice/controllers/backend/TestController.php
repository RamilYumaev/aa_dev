<?php
namespace modules\superservice\controllers\backend;

use modules\superservice\components\data\DocumentTypeVersionList;
use modules\superservice\forms\DocumentsDynamicForm;
use yii\web\Controller;
use yii\web\Response;

class TestController extends Controller
{
   public function actionIndex()
   {
       $array = (new DocumentTypeVersionList())->getArray()->filter(function ($v) {
           return $v['Id'] == 14;
       });
       $model = new DocumentsDynamicForm(array_values($array));
       $modelForm = $model->createDynamicModel();
       return $this->render('index',
           ['model' => $modelForm, 'fields'=> $model->getFields()]);
   }

    /**
     * @param $selectOn
     * @return array
     */

    public function actionDoc($selectOn)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if($selectOn) {
            $array = (new DocumentTypeVersionList())
                ->getArray()
                ->getArrayWithProperties(DocumentTypeVersionList::getPropertyForSelect(), true)
                ->filter(function ($v) use ($selectOn) {
                return $v['IdDocumentType'] == $selectOn;
            });
            return ['result' => array_values($array)];
        }
    }

    /**
     * @param $doc
     * @return array
     */

    public function actionVersion($doc)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if($doc) {
            $array = (new DocumentTypeVersionList())->getArrayForView()->filter(function ($v) use ($doc) {
                return $v['Id'] == $doc;
            });
            return ['result' => array_values($array)];
        }
    }
}
