<?php
namespace modules\superservice\controllers\backend;

use modules\superservice\components\DataXml;
use modules\usecase\GetClassAll;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @return string
     * @throws \ReflectionException
     */
   public function actionIndex()
   {
       $check = "modules\\superservice\\components\\data\\";
       $path = \Yii::getAlias('@modules').'/superservice/components/data/';
       $array = [];
       foreach ((new GetClassAll($check, $path))->getAllClasses() as $key => $class) {
           $rC = new \ReflectionClass($class);
           $array[$key]['text'] = (new $class())->getNameTitle();
           $array[$key]['name'] = $rC->getShortName();
       }
       return $this->render('index', ['result' => $array]);
   }

    /**
     * @param $name
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionTables($name)
    {
        $competitionListCache = \Yii::$app->competitionListCache;
        $cacheKey = ['ss'];
        $class = 'modules\\superservice\\components\\data\\'.$name;
        if(class_exists($class)) {
        return $competitionListCache->getOrSet($cacheKey, function () use ($class) {
            return $this->getProvider(new $class());
            });
        }
        throw new NotFoundHttpException('Класс не найден');
    }

    private function getProvider(DataXml $array) {
        $provider = new ArrayDataProvider([
            'allModels' => $array->getArrayForView(),
            'sort' => [
                'attributes' => $array->getKeys(),
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('tables', ['provider' => $provider, 'name'=> $array->getNameTitle(), 'keys' => $array->getAllAttributeWithLabel()]);
    }
}
