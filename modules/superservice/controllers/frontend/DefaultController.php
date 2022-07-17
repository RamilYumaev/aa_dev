<?php
namespace modules\superservice\controllers\frontend;

use modules\superservice\components\data\DocumentCategoryList;
use modules\superservice\components\data\DocumentTypeVersionList;
use modules\superservice\forms\DocumentsDynamicForm;
use modules\superservice\forms\SelectTypeDocumentsForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    public function actionIndex() {

        $model = new DocumentsDynamicForm($id);
        $modelForm = $model->createDynamicModel();
        return $this->render('index',
            ['model' => $modelForm, 'fields'=> $model->getFields()]);
    }
    /**
     * @param $category
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionForm($category) {

        $category = json_decode($category);
        $this->error($category);
        $model = new SelectTypeDocumentsForm($category);
        if($model->load(Yii::$app->request->post())) {
            $url = Yii::$app->request->getReferrer();
            $path = parse_url($url, PHP_URL_PATH);
            $query = parse_url($url, PHP_URL_QUERY);
            $pos = strpos($query, 'id=');
            $referrer = strpos($query, 'referrer=');
            $data = explode('&',$query);
            if($pos === false) {
                if($referrer === false) {
                    $path = $path.'?type='.$model->type.'&version='.$model->version;
                }else {
                    $path = $path.'?'.$data[0].'&type='.$model->type.'&version='.$model->version;
                }
            }else {
                if($referrer === false) {
                    $path = $path.'?'.$data[0].'&type='.$model->type.'&version='.$model->version;
                }else {
                    $path = $path.'?'.$data[0].'&type='.$model->type.'&version='.$model->version.'&'.$data[1];
                }
            }
            return $this->redirect($path);
        }
        return $this->renderAjax('_form', [ 'model' => $model]);
    }

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
     * @param $category
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    protected function error($category) {
        $data = (new DocumentCategoryList())->getArray()->column('Id');
        if(!in_array($category[0], $data)) {
            throw new NotFoundHttpException('Страница не найдена');
        }
    }
}
