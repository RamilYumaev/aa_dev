<?php
namespace modules\superservice\widgets;

use modules\superservice\components\data\DocumentTypeVersionList;
use Yii;
use yii\base\Widget;

class ButtonChangeVersionDocumentsWidgets extends Widget
{
    public $version;
    public $category;
    public $document;

    public function run()
    {
       return $this->render('index', [
           'category'=> $this->category,
           'data' => $this->getVersionDocument()]);
    }

    private function getVersion() {
        return Yii::$app->request->get('version') ?? $this->version;
    }

    private function getDocument() {
        return Yii::$app->request->get('type') ?? $this->document;
    }

    private function getVersionDocument() {
        if($this->getVersion() && $this->getDocument() && $this->category) {
            $documentVersion = new DocumentTypeVersionList();
            $array = $documentVersion
                ->getArray()
                ->getArrayWithProperties($documentVersion::getPropertyForSelect(), true)
                ->filter(function ($v) {
                return $v['Id'] == $this->getVersion()
                    && $v['IdDocumentType'] == $this->getDocument();
            });
            return array_values($array);
        }
        return [];
    }
}