<?php

namespace modules\entrant\forms;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\behaviors\EpguBehavior;
use modules\entrant\components\MaxDateValidate;
use modules\entrant\models\OtherDocument;
use modules\superservice\components\data\DocumentTypeVersionList;
use modules\superservice\forms\DocumentsDynamicForm;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class OtherDocumentForm extends Model
{
    public $type, $user_id, $amount, $series, $number, $date, $authority, $exemption_id, $without;

    private $arrayRequired;

    private $typesDocument;

    private $_otherDocument;

    public $isExemption;
    public $isAjax;

    public $type_document, $version_document, $other_data, $reception_quota;

    private $idIa;

    public function __construct($user_id,
                                $ajax = false,
                                OtherDocument $otherDocument = null,
                                $exemption = false,
                                $arrayRequired = [],
                                $typesDocument = [],
                                $idIa = null,
                                $config = [])
    {
        $this->idIa = $idIa;
        $this->isExemption = $exemption;
        $this->isAjax = $ajax;
        $this->typesDocument = $typesDocument;
        $this->arrayRequired = $arrayRequired;
        if($otherDocument){
            $this->setAttributes($otherDocument->getAttributes(), false);
            $this->date=$otherDocument->date ? $otherDocument->getValue("date"): null;
            $this->_otherDocument = $otherDocument;
            $this->other_data = $otherDocument->other_data ? json_decode($otherDocument->other_data, true) : [];

        }
        $this->user_id = $user_id;
        parent::__construct($config);
    }

    public function behaviors()
    {
        return [
            ['class' =>EpguBehavior::class, 'dynamicModel'=> $this->getDocumentsDynamicForm()]
        ];
    }

    public function getDocumentsDynamicForm() {
        $this->type_document = \Yii::$app->request->get('type') ??  $this->type_document;
        $this->version_document = \Yii::$app->request->get('version') ?? $this->version_document;
        return new DocumentsDynamicForm($this->version_document);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [$this->required(), 'required'],
            [['type','amount', 'exemption_id','without', 'reception_quota'], 'integer'],
            [['series',], 'string', 'max' => 10],
            [['number', 'authority'], 'string', 'max' => 255],
            [['date',], 'safe'],
            $this->versionDocument(),
            [['date'], MaxDateValidate::class],
            [['amount'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_PHOTO;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 45}'],
            [['date'], 'required', 'when' => function ($model) {
                return $model->type == DictIncomingDocumentTypeHelper::ID_MEDICINE;},
                'whenClient' => 'function (attribute, value) { return $("#otherdocumentform-type").val() == 29}'],
            ['type', 'in', 'range' => $this->rangeValidation()
            ],
        ];
    }

    private function required() {

        if ($this->arrayRequired) {
            $attribute = $this->arrayRequired;
        }else {
            $attribute =['type'];
        }
       return $attribute;
    }

    public function typeDocuments() {
        if($this->typesDocument) {
            return $this->typesDocument;
        }
        return [
            /* DictIncomingDocumentTypeHelper::TYPE_EDUCATION_VUZ, */
            DictIncomingDocumentTypeHelper::TYPE_MEDICINE,
            DictIncomingDocumentTypeHelper::TYPE_OTHER
        ];
    }

    private function rangeValidation() {
        if($this->idIa) {
            return DictIncomingDocumentTypeHelper::rangeIds($this->idIa);
        }
        return DictIncomingDocumentTypeHelper::rangeType($this->typeDocuments());
    }

    /**
     * {@inheritdoc}
     */
    public function versionDocument()
    {
        $documentVersion = new DocumentTypeVersionList();
        $array = $documentVersion
            ->getArray()
            ->filter(function ($v) {
                return $v['IdDocumentType'] == $this->type_document;
            });
        if($array && count($array) > 1) {
            $data = array_filter($array, function ($v){
                return  $v['Id'] == $this->version_document;
            });
            if($data) {
                $data =array_values($data);
                $year = DocumentTypeVersionList::getVersions()[$data[0]['DocVersion']]['value'] ?? date('Y');
                return [['date'], 'date', 'format' => 'dd.mm.yyyy', 'max' => "31.12.$year"];
            }
            return [['date'], 'date', 'format' => 'dd.mm.yyyy'];

        }else {
            return [['date'], 'date', 'format' => 'dd.mm.yyyy'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['type',  'series', 'number'], 'unique', 'targetClass' => OtherDocument::class, 'targetAttribute' => ['type', 'series', 'user_id', 'number']];
        if ($this->_otherDocument) {
            return ArrayHelper::merge($arrayUnique, [ 'filter' => ['<>', 'id', $this->_otherDocument->id]]);
        }
        return $arrayUnique;
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new OtherDocument())->attributeLabels();
    }

    public function  listTypesDocument() {
        if($this->idIa) {
          return  DictIncomingDocumentTypeHelper::listId($this->idIa);
        }
        return DictIncomingDocumentTypeHelper::listType($this->typeDocuments());
    }

}