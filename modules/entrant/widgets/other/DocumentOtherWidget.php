<?php
namespace modules\entrant\widgets\other;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\services\OtherDocumentService;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use Yii;


class DocumentOtherWidget extends Widget
{
    const COUNT_PHOTO  = 1;
    private $service;

    public function __construct(OtherDocumentService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function init()
    {
        try {
            $form = new OtherDocumentForm(false, $this->modelOne(), false, [], [], null, [
            'type'=> DictIncomingDocumentTypeHelper::ID_PHOTO, 'amount'=> $this->facultyCount()* self::COUNT_PHOTO]);
            $this->serviceOther($form,$this->modelOne());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

    }

    public function run()
    {
        $query = OtherDocument::find()->where(['user_id' => $this->getIdUser()]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    private function serviceOther(OtherDocumentForm $form, OtherDocument $model = null ) {
         if($model) {
             if ($form->amount != $model->amount) {
                 $this->service->edit($model->id, $form);
             }
         }else {
             $this->service->create($form);
         }
    }

    private function modelOne() : ? OtherDocument
    {
        return OtherDocument::findOne(['type' => DictIncomingDocumentTypeHelper::ID_PHOTO,'user_id' => $this->getIdUser()]);

    }

    private function getIdUser() {
        return \Yii::$app->user->identity->getId();
    }

    private function facultyCount() {
       return DictCompetitiveGroupHelper::groupByFacultyCountUser($this->getIdUser());
    }

}
